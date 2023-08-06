<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class GitPullCommand extends Command
{
    protected $signature = 'git:pull';

    protected $description = 'Git Pull Command description';

    public function handle()
    {
        Process::run(['git', 'pull'], function () {
            $this->components->info('Server Updated');
        });
    }
}
