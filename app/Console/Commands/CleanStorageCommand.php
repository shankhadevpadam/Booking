<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanStorageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clean {name=public}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean storage directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dir = storage_path('app/'.$this->argument('name'));

        File::cleanDirectory($dir);

        return Command::SUCCESS;
    }
}
