<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\ImageManager;
use App\Models\Student;
use Illuminate\Support\Str;

class MakeCard implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    // ------- BARCODE controls -------
    private const BARCODE_W         = 1800; // final footprint width (px)
    private const BARCODE_H         = 120;  // final footprint height (px)
    private const BARCODE_OFFSET_X  = -220;    // nudge after centering (left = negative)
    private const BARCODE_OFFSET_Y  = 75;    // nudge after centering (down = positive)

    // ------- TEXT controls (your values preserved) -------
    private const ID_LABEL_PAD      = 100;  // reserved for the blue "ID" chip
    private const ID_TEXT_SIZE      = 70;   // fixed font size
    private const ID_TEXT_OFFSET_X  = -170; // nudge after centering
    private const ID_TEXT_OFFSET_Y  =  85;  // nudge after centering

    public function __construct(
        public int $studentId,
        public string $templatePath,
        public string $outDir,
        public ?string $fontPath = null
    ) {}

    public function handle(): void
    {

        $images  = new ImageManager(['driver' => 'gd']);
        $student = Student::find($this->studentId);
        if (!$student) return;

        $card = $images->make($this->templatePath)->encode('png');

        $W = $card->width();
        $H = $card->height();

        // White pill under “SCAN ME”
        $white = [
            'x' => (int) round($W * 0.120),
            'y' => (int) round($H * 0.395),
            'w' => (int) round($W * 0.450),
            'h' => (int) round($H * 0.125),
        ];

        // ID bar (long white box with the blue “ID” label at left)
        $idBar = [
            'x' => (int) round($W * 0.145),
            'y' => (int) round($H * 0.620),
            'w' => (int) round($W * 0.430),
            'h' => (int) round($H * 0.085),
        ];

        /* ---------- BARCODE (fixed footprint + offsets) ---------- */

        $b64 = \DNS1D::getBarcodePNG($student->code, 'C128', 6, 160, [0,0,0], false);
        if (!$b64) return;

        $raw = $images->make(base64_decode($b64))->encode('png');

        // Fit the raw barcode INSIDE the fixed footprint while preserving aspect
        $scaled = clone $raw;
        // scale by height first
        $scaled->resize(null, self::BARCODE_H, function ($c) { $c->aspectRatio(); $c->upsize(); });
        // if too wide, clamp by width

        if ($scaled->width() > self::BARCODE_W) {
            $scaled->resize(self::BARCODE_W, null, function ($c) { $c->aspectRatio(); $c->upsize(); });
        }

        // Center inside a fixed canvas of BARCODE_W x BARCODE_H
        $barcodeCanvas = $images->canvas(self::BARCODE_W, self::BARCODE_H, null);
        $cx = (int) floor((self::BARCODE_W - $scaled->width()) / 2);
        $cy = (int) floor((self::BARCODE_H - $scaled->height()) / 2);
        $barcodeCanvas->insert($scaled, 'top-left', max(0,$cx), max(0,$cy));

        // Paste the fixed canvas centered in the white pill, then apply offsets
        $bx = $white['x'] + (int) floor(($white['w'] - self::BARCODE_W) / 2) + self::BARCODE_OFFSET_X;
        $by = $white['y'] + (int) floor(($white['h'] - self::BARCODE_H) / 2) + self::BARCODE_OFFSET_Y;
        $card->insert($barcodeCanvas, 'top-left', $bx, $by);

        /* ---------- CODE TEXT (fixed size + offsets, unchanged) ---------- */

        // choose bold font
        $fontPath = $this->fontPath;
        if (!$fontPath || !is_file($fontPath)) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && is_file('C:\Windows\Fonts\arialbd.ttf')) {
                $fontPath = 'C:\Windows\Fonts\arialbd.ttf';
            } elseif (is_file('/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf')) {
                $fontPath = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
            } else {
                $fontPath = null;
            }
        }

        $text = (string) $student->code;

        // usable region (skip the “ID” chip area)
        $useX = $idBar['x'] + self::ID_LABEL_PAD;
        $useY = $idBar['y'];
        $useW = $idBar['w'] - self::ID_LABEL_PAD;
        $useH = $idBar['h'];

        // measure text at fixed size (no auto-shrink)
        $fontSize = self::ID_TEXT_SIZE;
        $tw = (int) round($useW * 0.5);
        $th = (int) round($useH * 0.8);
        if ($fontPath && function_exists('imagettfbbox')) {
            $box = imagettfbbox($fontSize, 0, $fontPath, $text);
            $tw  = abs($box[2] - $box[0]);
            $th  = abs($box[7] - $box[1]);
        }

        // center within usable region, then apply nudges
        $textX = (int) floor($useX + ($useW - $tw) / 2) + self::ID_TEXT_OFFSET_X;
        $textY = (int) floor($useY + ($useH - $th) / 2) + self::ID_TEXT_OFFSET_Y;

        $card->text($text, $textX, $textY, function ($font) use ($fontSize, $fontPath) {
            if ($fontPath) $font->file($fontPath);
            $font->size($fontSize);
            $font->color('#0A2E6C');
            $font->align('left'); // top-left anchor computed above
            $font->valign('top');
        });

        /* ---------- SAVE ---------- */

        @mkdir($this->outDir, 0775, true);
        $safe = Str::slug($student->code ?: ("student-{$student->id}"), '_');
        $card->save("{$this->outDir}/{$safe}.png", 90, 'png');
    }
}
