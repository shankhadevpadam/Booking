<?php

namespace App\Console\Commands;

use App\Models\PackageDeparture;
use Illuminate\Console\Command;

class TrashExpiredDepartureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trash:departure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trash the old departure';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        PackageDeparture::where('start_date', '<=', now()->subDay())->delete();

        return Command::SUCCESS;
    }
}
