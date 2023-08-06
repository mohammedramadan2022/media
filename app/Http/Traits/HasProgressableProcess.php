<?php

namespace App\Http\Traits;

use Illuminate\Process\InvokedProcess;
use Illuminate\Support\Facades\Process;

trait HasProgressableProcess
{
    private function createProgressBarCommand($commandText, $max): InvokedProcess|bool
    {
        $this->output->progressStart($max);

        $command = Process::start($commandText);

        while ($command->running()) {
            sleep(1);
            $this->output->progressAdvance();
        }

        if (! $command->wait()) {
            $this->components->error($command->errorOutput());

            return false;
        }

        $command->wait();

        $this->output->progressFinish();

        return $command;
    }
}
