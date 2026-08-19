<?php

namespace App\Http\Controllers\Admin\Capacitors;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Capacitors\CreateCardsRequest;
use App\Models\CapacitorCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CardController extends Controller
{
    use PaginatesAdminTables;

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());

        $summaryQuery = CapacitorCard::query()
            ->select('batch', 'title')
            ->selectRaw('COUNT(batch) as total')
            ->selectRaw('MIN(created_at) as batch_created_at')
            ->groupBy('batch', 'title');

        $batches = $this->paginateAdminTable(
            DB::query()->fromSub($summaryQuery, 'card_batches')->orderByDesc('batch'),
            $request
        );

        $dataLables = [
            'العنوان',
            'عدد الكروت',
            'Batch',
            'وقت الإنشاء',
            'إنشاء بواسطة',
            'إدارة',
        ];
        $dataRows = [];

        foreach ($batches as $key => $model) {
            $card = CapacitorCard::where('batch', $model->batch)->first();
            $dataRows[$key][] = $model->title;
            $dataRows[$key][] = $model->total;
            $dataRows[$key][] = $model->batch;
            $dataRows[$key][] = $model->batch_created_at
                ? date('d M Y - H:i:s', strtotime($model->batch_created_at))
                : '—';
            $dataRows[$key][] = $card?->createdBy?->name ?? '—';
            $dataRows[$key][] = [
                'id' => $model->batch,
                'delete' => true,
                'view' => true,
                'edit' => false,
                'viewLabel' => 'تحميل',
            ];
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'batches' => $batches,
        ]);
    }

    public function create(CreateCardsRequest $request): RedirectResponse
    {
        $total = 0;
        $batch = ((CapacitorCard::latest('batch')->first())?->batch ?? 0) + 1;
        $createdBy = auth('admin')->user()->id;
        $title = $request->title;

        for ($i = 0; $i < $request->count; $i++) {
            $uuid4 = Uuid::uuid4()->toString();
            $code = explode('-', $uuid4)[4];

            if (CapacitorCard::where('code', $code)->doesntExist()) {
                $created = CapacitorCard::create([
                    'title' => $title,
                    'code' => $code,
                    'batch' => $batch,
                    'created_by' => $createdBy,
                ]);

                if ($created) {
                    $total += 1;
                }
            }
        }

        return redirect()
            ->route('admin.capacitors.card.index')
            ->with('success', "تم إنشاء ({$total}) كرت بنجاح");
    }

    public function delete($batch): RedirectResponse
    {
        DB::table('capacitor_cards')->where('batch', $batch)->delete();

        return redirect()
            ->route('admin.capacitors.card.index')
            ->with('success', 'تم حذف الكروت بنجاح');
    }

    public function view($batch): BinaryFileResponse
    {
        $cards = CapacitorCard::where('batch', $batch)->get();
        $content = "Code,Batch,count,Visited\n";

        foreach ($cards as $card) {
            $content .= "{$card->code},{$card->batch},".($card->count ?? '').','.($card->visited ?? 'no')."\n";
        }

        $fileName = "offline_cards_batch_{$batch}.csv";
        $tempPath = storage_path('app/public/'.$fileName);
        file_put_contents($tempPath, $content);

        return response()->download($tempPath, $fileName, [
            'Content-Type' => 'text/csv',
        ])->deleteFileAfterSend(true);
    }
}
