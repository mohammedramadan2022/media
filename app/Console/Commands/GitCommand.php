<?php

namespace App\Console\Commands;

use App\Http\Traits\HasProgressableProcess;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class GitCommand extends Command
{
    use HasProgressableProcess;

    protected $signature = 'git {message?}';

    protected $description = 'Upload the changes to git repo';

    public function handle(): void
    {
        $message = $this->argument('message') ?? date('Y-m-d');

        Process::run('git add .');

        Process::run('git commit -m '.$message);

        self::createProgressBarCommand('git push',100);

        Process::run('git status');

        $this->components->info('Repository updated successfully !');
    }
}
