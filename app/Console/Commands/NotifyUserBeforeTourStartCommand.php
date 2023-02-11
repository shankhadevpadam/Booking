<?php

namespace App\Console\Commands;

use App\Models\UserPackage;
use App\Notifications\UserBeforeTourStartNotification;
use Illuminate\Console\Command;

class NotifyUserBeforeTourStartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:user-notify
                            {days? : Number of days} 
                            {--month : If month option is passed apply month instead of days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to user before x days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userPackages = UserPackage::where('is_paid', true)
            ->where(function ($query) {
                if ($this->option('month')) {
                    $query->whereDate('start_date', now()->addMonth());
                } else {
                    $query->whereDate('start_date', now()->addDays($this->argument('days')));
                }
            })
            ->with(['user:id,name,email'])
            ->select('user_id', 'start_date', 'arrival_date', 'arrival_time')
            ->get();

        $userPackages->each(function ($item) {
            $item->user->notify(new UserBeforeTourStartNotification([
                'start_date' => $item->start_date->toDateString(),
                'arrival_date' => ($item->arrival_date ? $item->arrival_date->toDateString() : '').' '.($item->arrival_time ? $item->arrival_time->toTimeString() : ''),
            ]));
        });

        $this->info('Notify user successfully.');

        return Command::SUCCESS;
    }
}
