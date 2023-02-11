<?php

namespace App\Http\Livewire\Package;

use App\Enums\DiscountApply;
use App\Enums\DiscountType;
use App\Models\PackageDeparture as Departure;
use Carbon\CarbonPeriod;
use Livewire\Component;

class PackageDeparture extends Component
{
    public $packageId;

    public $startDate;

    public $endDate;

    public $price;

    public $discountType;

    public $discountApplyOn;

    public $discountAmount;

    public $quantity;

    public $duration = 1;

    public $interval = 1;

    protected $rules = [
        'startDate' => ['required', 'date'],
        'endDate' => ['required', 'date', 'after_or_equal:startDate'],
        'price' => ['required'],
        'discountApplyOn' => ['required_with:discountType'],
        'quantity' => ['required', 'integer'],
    ];

    public function close()
    {
        $this->resetErrorBag();
        $this->reset(['startDate', 'endDate', 'price', 'discountType', 'discountApplyOn', 'discountAmount', 'quantity', 'duration', 'interval']);
    }

    public function save()
    {
        if ($this->discountApplyOn) {
            $this->rules['discountAmount'] = ['required', 'integer'];
        }

        $this->validate();

        if ($this->startDate === $this->endDate) {
            $departures[] = [
                'package_id' => $this->packageId->id,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'price' => $this->price,
                'discount_type' => $this->discountType,
                'discount_apply_on' => $this->discountApplyOn,
                'discount_amount' => $this->discountAmount,
                'total_quantity' => $this->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        } else {
            $dates = new CarbonPeriod($this->startDate, $this->interval.' days', $this->endDate);

            foreach ($dates->toArray() as $dt) {
                if ($dt->format('Y-m-d') === $this->endDate) {
                    break;
                }

                $departures[] = [
                    'package_id' => $this->packageId->id,
                    'start_date' => $dt->format('Y-m-d'),
                    'end_date' => $dt->addDays($this->duration - 1)->format('Y-m-d'),
                    'price' => $this->price,
                    'discount_type' => $this->discountType,
                    'discount_apply_on' => $this->discountApplyOn,
                    'discount_amount' => $this->discountAmount,
                    'total_quantity' => $this->quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Departure::insert($departures);

        $this->reset(['startDate', 'endDate', 'price', 'discountType', 'discountApplyOn', 'discountAmount', 'quantity', 'duration', 'interval']);

        $this->emit('updateDatatable');
    }

    public function render()
    {
        return view('livewire.package.package-departure', [
            'discountTypes' => DiscountType::cases(),
            'discountApplyOnTypes' => DiscountApply::cases(),
        ]);
    }
}
