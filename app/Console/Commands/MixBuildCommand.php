<?php

namespace App\Console\Commands;

use App\Http\Traits\HasProgressableProcess;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class MixBuildCommand extends Command
{
    use HasProgressableProcess;

    protected $signature = 'mix';

    protected $description = 'Mix Build and git push Command description';

    public function handle(): void
    {
        $this->components->twoColumnDetail('MIX', 'Building');

        $command = self::createProgressBarCommand('npm run prod', 100);

        $this->info($command->output());

        $this->components->twoColumnDetail('GIT','Pushing');

        $git = self::createProgressBarCommand('php artisan git',100);

        Process::run('git status');

        $this->components->info($git->output());
    }
}
