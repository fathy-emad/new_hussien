<?php

namespace App\Support;

use Symfony\Component\Process\Process;

class StudentCardQueue
{
    public static function dispatchAndWork(object $job): void
    {
        dispatch($job);
        static::startWorker();
    }

    private static function startWorker(): void
    {
        $command = [
            PHP_BINARY,
            base_path('artisan'),
            'queue:work',
            '--stop-when-empty',
            '--tries=1',
            '--timeout=7200',
            '--memory=1024',
        ];

        if (PHP_OS_FAMILY === 'Windows') {
            $line = implode(' ', array_map('escapeshellarg', $command));
            pclose(popen('start /B "" '.$line, 'r'));

            return;
        }

        $process = new Process($command, base_path());
        $process->setTimeout(null);
        $process->disableOutput();
        $process->start();
    }
}
