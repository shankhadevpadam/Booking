<?php

namespace App\Console\Commands;

use App\Models\UserPackage;
use App\Notifications\ReviewNotification;
use Illuminate\Console\Command;

class NotifyUserReviewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:review-email {days=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send review notification after x days when tour is completed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userPackages = UserPackage::with(['user:id,name,email', 'package:id,name', 'agency:id,user_package_id,guide_id'])
            ->where(function ($query) {
                $query->whereDate('end_date', now()->subDays($this->argument('days')));
                $query->where('is_paid', true);
                $query->where('send_review_email', true);
            })
            ->select('id', 'user_id', 'package_id')
            ->get();
            
        $userPackages->each(function ($userPackage) {
            $userPackage->user->notify(new ReviewNotification([
                'package_name' => $userPackage->package->name,
                'package_id' => $userPackage->package_id,
                'guide_id' => $userPackage->agency->guide_id ?? '',
            ]));
        });

        $this->info('Review notification email send successfully.');

        return Command::SUCCESS;
    }
}
