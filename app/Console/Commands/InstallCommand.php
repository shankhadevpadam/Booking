<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('Are you sure to run this command. All database table and storage file should be delete, Run your own risk.')) {
            $this->call('migrate:fresh');
            $this->call('db:seed');
            $this->call('storage:clean');
            $this->info('Application installed successfully.');
        }

        return Command::SUCCESS;
    }
}
