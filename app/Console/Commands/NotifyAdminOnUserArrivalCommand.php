<?php

namespace App\Console\Commands;

use App\Models\UserPackage;
use App\Notifications\AdminUserArrivalNotification;
use Illuminate\Console\Command;

class NotifyAdminOnUserArrivalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:user-arrival 
                            {--hour : If hour option is passed get user before hour}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send user arrival notification to admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userPackages = UserPackage::with(['user:id,name,email'])
            ->where('is_paid', true)
            ->where(function ($query) {
                $query->whereDate('arrival_date', today('Asia/Kathmandu'));

                $query->when($this->option('hour'), function ($query) {
                    $query->whereTime('arrival_time', now('Asia/Kathmandu')->addHour()->format('H:i'));
                });
            })
            ->select('id', 'user_id', 'departure_id', 'start_date', 'end_date', 'arrival_date', 'arrival_time', 'flight_number', 'airport_pickup')
            ->get();

        $userPackages->each(function ($userPackage) {
            admin()->notify(new AdminUserArrivalNotification($userPackage));
        });

        return Command::SUCCESS;
    }
}
