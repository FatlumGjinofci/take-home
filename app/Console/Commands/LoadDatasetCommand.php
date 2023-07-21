<?php

namespace App\Console\Commands;

use App\Jobs\CommentsJob;
use Illuminate\Console\Command;

class LoadDatasetCommand extends Command
{
    protected $signature = 'load:dataset';

    protected $description = 'Load comments dataset';

    public function handle()
    {
        //CommentsJob::dispatch();

        $this->info('Dataset load completed!');
    }
}
