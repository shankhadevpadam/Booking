<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\UserPackageAgency;
use App\Notifications\AdminGuideAssignNotification;
use App\Notifications\GuideAssignNotification;
use App\Notifications\TrekkerAssignNotification;
use Livewire\Component;

class AssignGuide extends Component
{
    public $guideId;

    public $guides;

    public $userPackageId;

    protected $rules = [
        'guideId' => ['required'],
    ];

    public function mount()
    {
        $userAgency = UserPackageAgency::where('user_package_id', $this->userPackageId)->first();

        if ($userAgency) {
            $this->guideId = $userAgency->guide_id;
        }
    }

    public function save()
    {
        $this->validate();

        $userPackageAgency = UserPackageAgency::updateOrCreate([
            'user_package_id' => $this->userPackageId,
        ], [
            'guide_id' => $this->guideId,
        ]);

        $userPackageAgency->load(['userPackage.user', 'userPackage.addons', 'guide']);

        $this->sendNotificationToGuide($userPackageAgency);

        $this->sendNotificationToClient($userPackageAgency);

        $this->sendNotificationToAdmin($userPackageAgency);

        $this->dispatchBrowserEvent('assign-guide', [
            'message' => 'Assign guide successfully.',
            'guide' => $userPackageAgency->guide->name,
        ]);
    }

    public function sendNotificationToGuide($userPackageAgency): void
    {
        $userPackageAgency->userPackage->user->notify(new GuideAssignNotification([
            'name' => $userPackageAgency->guide->name,
        ]));
    }

    public function sendNotificationToClient($userPackageAgency): void
    {
        $addons = '';

        if ($userPackageAgency->userPackage->addons->isNotEmpty()) {
            $addons = $userPackageAgency->userPackage
                ->addons
                ->map(function ($item) {
                    return "{$item->name} - {$item->count}";
                })
                ->join(',');
        }

        $userPackageAgency->guide->notify(new TrekkerAssignNotification([
            'name' => $userPackageAgency->userPackage->user->name,
            'number_of_trekkers' => $userPackageAgency->userPackage->number_of_trekkers,
            'trek_date' => "{$userPackageAgency->userPackage->start_date->toDateString()} - {$userPackageAgency->userPackage->end_date->toDateString()}",
            'trip_name' => $userPackageAgency->userPackage->package->name,
            'addons' => $addons,
        ]));
    }

    public function sendNotificationToAdmin($userPackageAgency): void
    {
        $admin = User::role('Super Admin')->first();

        $admin->notify(new AdminGuideAssignNotification([
            'name' => $userPackageAgency->userPackage->user->name,
            'deposit' => $this->totalPaidAmount($userPackageAgency),
            'remaining_amount' => $userPackageAgency->userPackage->total_amount - $this->totalPaidAmount($userPackageAgency),
        ]));
    }

    public function totalPaidAmount($userPackageAgency)
    {
        $filteredPayments = $userPackageAgency->userPackage->payments->filter(function ($item) {
            return ! (str_contains($item->payment_type, 'additional') || str_contains($item->payment_type, 'refund'));
        });

        return $filteredPayments->sum('amount');
    }

    public function close()
    {
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.user.assign-guide');
    }
}
