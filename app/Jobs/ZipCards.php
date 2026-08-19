<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ZipCards implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $cardsDir,
        public string $publicZipPath
    ) {}

    public function handle(): void
    {
        @mkdir(dirname($this->publicZipPath), 0775, true);
        $files = glob($this->cardsDir . '/*.png') ?: [];

        // Prefer ext-zip if available; else ZipStream fallback
        if (class_exists(\ZipArchive::class)) {

            $tmpZip = storage_path('app/tmp/' . basename($this->publicZipPath));
            @mkdir(dirname($tmpZip), 0775, true);

            $zip = new \ZipArchive();
            if ($zip->open($tmpZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                \Log::error('ZipCards: could not open tmp zip', ['tmp' => $tmpZip]);
                return;
            }

            if (empty($files)) {
                // Create a valid zip anyway so the URL exists
                $zip->addFromString('README.txt', "No images were generated.\r\n");
            } else {
                foreach ($files as $f) {
                    $zip->addFile($f, basename($f));
                }
            }
            $zip->close();

            // Move into public/ with fallback copy on Windows
            @unlink($this->publicZipPath);
            if (!@rename($tmpZip, $this->publicZipPath)) {
                if (!@copy($tmpZip, $this->publicZipPath)) {
                    \Log::error('ZipCards: failed to publish zip', ['dest' => $this->publicZipPath]);
                    @unlink($tmpZip);
                    return;
                }
                @unlink($tmpZip);
            }

        } else {
            // ZipStream fallback
            if (!class_exists(\ZipStream\ZipStream::class)) {
                \Log::error('ZipCards: no ZipArchive and ZipStream missing');
                return;
            }

            $stream = @fopen($this->publicZipPath, 'wb');
            if (!$stream) {
                \Log::error('ZipCards: cannot open destination for writing', ['dest' => $this->publicZipPath]);
                return;
            }

            $opts = new \ZipStream\Option\Archive();
            $opts->setOutputStream($stream);
            $zip = new \ZipStream\ZipStream(basename($this->publicZipPath), $opts);

            if (empty($files)) {
                $zip->addFile('README.txt', "No images were generated.\r\n");
            } else {
                foreach ($files as $f) {
                    $zip->addFileFromPath(basename($f), $f);
                }
            }
            $zip->finish();
            fclose($stream);
        }

        // Cleanup PNGs (if any)
        foreach ($files as $f) { @unlink($f); }
        @rmdir($this->cardsDir);

        \Log::info('ZipCards: zip ready', ['url' => asset('cards/' . basename($this->publicZipPath))]);
    }
}
