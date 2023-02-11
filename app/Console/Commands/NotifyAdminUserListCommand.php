<?php

namespace App\Console\Commands;

use App\Models\UserPackage;
use App\Notifications\AdminUserListNotification;
use Illuminate\Console\Command;

class NotifyAdminUserListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:user-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send coming week user list notification to admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userPackages = UserPackage::where('is_paid', true)
            ->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->with(['user:id,name,email'])
            ->select('id', 'user_id', 'departure_id', 'start_date', 'end_date', 'arrival_date', 'arrival_time', 'flight_number', 'airport_pickup')
            ->get();

        $data = $userPackages->map(function ($item) {
            return [
                'name' => $item->user->name,
                'email' => $item->user->email,
                'start_date' => $item->start_date->toDateString(),
                'end_date' => $item->end_date->toDateString(),
                'arrival_date' => $item->arrival_date ? $item->arrival_date->toDateString() : 'N/A',
                'arrival_time' => $item->arrival_time ? $item->arrival_time->toTimeString() : 'N/A',
                'flight_number' => $item->flight_number ?? 'N/A',
                'airport_pickup' => $item->airport_pickup,
            ];
        })->all();

        if (count($data)) {
            admin()->notify(new AdminUserListNotification($data));

            $this->info('User list email send successfully.');
        }

        return Command::SUCCESS;
    }
}
