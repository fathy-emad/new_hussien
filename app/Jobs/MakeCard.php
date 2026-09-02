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
    private const BARCODE_W         = 1500; // final footprint width (px)
    private const BARCODE_H         = 150;  // final footprint height (px)
    private const BARCODE_OFFSET_X  = 170;    // nudge after centering (left = negative)
    private const BARCODE_OFFSET_Y  = -160;    // nudge after centering (down = positive)

    // ------- CODE (ID) controls — independent of password -------
    private const CODE_LABEL_PAD    = 100;  // skip the green "ID" chip
    private const CODE_TEXT_SIZE    = 55;
    private const CODE_OFFSET_X     = 150; // left = negative, right = positive
    private const CODE_OFFSET_Y     =  -50;  // up = negative, down = positive

    // ------- PASSWORD controls — independent of code -------
    private const PASSWORD_LABEL_PAD = 180; // skip the green "PASSWORD" chip
    private const PASSWORD_TEXT_SIZE = 42;
    private const PASSWORD_OFFSET_X  = 100;   // left = negative, right = positive
    private const PASSWORD_OFFSET_Y  = 20;   // up = negative, down = positive

    public function __construct(
        public int $studentId,
        public string $templatePath,
        public string $outDir,
        public ?string $fontPath = null,
        public ?string $plainPassword = null
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

        // ID bar (white box next to the green “ID” label)
        $idBar = [
            'x' => (int) round($W * 0.145),
            'y' => (int) round($H * 0.620),
            'w' => (int) round($W * 0.430),
            'h' => (int) round($H * 0.085),
        ];

        // Password bar (white box next to the green “PASSWORD” label)
        $passBar = [
            'x' => (int) round($W * 0.145),
            'y' => (int) round($H * 0.752),
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

        $useX = $idBar['x'] + self::CODE_LABEL_PAD;
        $useY = $idBar['y'];
        $useW = $idBar['w'] - self::CODE_LABEL_PAD;
        $useH = $idBar['h'];

        $fontSize = self::CODE_TEXT_SIZE;
        $tw = (int) round($useW * 0.5);
        $th = (int) round($useH * 0.8);
        if ($fontPath && function_exists('imagettfbbox')) {
            $box = imagettfbbox($fontSize, 0, $fontPath, $text);
            $tw  = abs($box[2] - $box[0]);
            $th  = abs($box[7] - $box[1]);
        }

        $textX = (int) floor($useX + ($useW - $tw) / 2) + self::CODE_OFFSET_X;
        $textY = (int) floor($useY + ($useH - $th) / 2) + self::CODE_OFFSET_Y;

        $card->text($text, $textX, $textY, function ($font) use ($fontSize, $fontPath) {
            if ($fontPath) $font->file($fontPath);
            $font->size($fontSize);
            $font->color('#0A2E6C');
            $font->align('left');
            $font->valign('top');
        });

        /* ---------- PASSWORD TEXT (own offsets, no extra box/label) ---------- */

        $plainPassword = (string) ($this->plainPassword ?? '');
        if ($plainPassword !== '') {
            $passUseX = $passBar['x'] + self::PASSWORD_LABEL_PAD;
            $passUseY = $passBar['y'];
            $passUseW = $passBar['w'] - self::PASSWORD_LABEL_PAD;
            $passUseH = $passBar['h'];

            $passSize = self::PASSWORD_TEXT_SIZE;
            $pw = (int) round($passUseW * 0.5);
            $ph = (int) round($passUseH * 0.8);
            if ($fontPath && function_exists('imagettfbbox')) {
                $pbox = imagettfbbox($passSize, 0, $fontPath, $plainPassword);
                $pw = abs($pbox[2] - $pbox[0]);
                $ph = abs($pbox[7] - $pbox[1]);
            }

            $passX = (int) floor($passUseX + ($passUseW - $pw) / 2) + self::PASSWORD_OFFSET_X;
            $passY = (int) floor($passUseY + ($passUseH - $ph) / 2) + self::PASSWORD_OFFSET_Y;

            $card->text($plainPassword, $passX, $passY, function ($font) use ($passSize, $fontPath) {
                if ($fontPath) {
                    $font->file($fontPath);
                }
                $font->size($passSize);
                $font->color('#0A2E6C');
                $font->align('left');
                $font->valign('top');
            });
        }

        /* ---------- SAVE ---------- */

        @mkdir($this->outDir, 0775, true);
        $safe = Str::slug($student->code ?: ("student-{$student->id}"), '_');
        $card->save("{$this->outDir}/{$safe}.png", 90, 'png');
    }
}
