<?php

namespace App\Http\Livewire\User;

use App\Models\Bank;
use App\Models\Currency;
use App\Models\UserPackage;
use App\Notifications\AdditionalPaymentNotification;
use Livewire\Component;

class AdditionalPayment extends Component
{
    public UserPackage $userPackage;

    public string $paymentMethod = 'card';

    public string $bankId = '';

    public string $currencyId = '';

    public float $bankCharge = 0;

    public float $amount = 0;

    public float $totalAmount = 0;

    public string $notes = '';

    protected $rules = [
        'currencyId' => ['required'],
        'notes' => ['required'],
        'amount' => ['required', 'numeric'],
    ];

    public function getBanksProperty()
    {
        return Bank::toBase()->get();
    }

    public function getCurrenciesProperty()
    {
        return Currency::toBase()->get();
    }

    public function changePaymentMethod()
    {
        $this->bankId = '';

        $this->bankCharge = 0;

        $this->bankChargeAmount = 0;

        $this->totalAmount = 0;
    }

    public function changeBank()
    {
        $this->bankCharge = Bank::find($this->bankId)->charge ?? 0;

        $this->bankChargeAmount = round(($this->amount * $this->bankCharge) / 100, 2);

        $this->totalAmount = $this->bankCharge ? round($this->amount + ($this->amount * $this->bankCharge) / 100, 2) : 0;
    }

    public function changeAmount()
    {
        if (empty($this->amount) || ! is_numeric($this->amount)) {
            return 0;
        }

        $this->bankCharge = Bank::find($this->bankId)->charge ?? 0;

        $this->bankChargeAmount = round(($this->amount * $this->bankCharge) / 100, 2);

        $this->totalAmount = $this->bankCharge ? round($this->amount + ($this->amount * $this->bankCharge) / 100, 2) : 0;
    }

    public function save()
    {
        $this->validate();

        $data[] = [
            'currency_id' => $this->currencyId,
            'bank_id' => $this->bankId ? $this->bankId : null,
            'payment_method' => $this->paymentMethod,
            'payment_type' => 'additional',
            'amount' => $this->amount,
            'notes' => $this->notes,
        ];

        if ($this->bankChargeAmount > 0) {
            array_push($data, [
                'currency_id' => $this->currencyId,
                'bank_id' => $this->bankId ? $this->bankId : null,
                'payment_method' => $this->paymentMethod,
                'payment_type' => 'additional_bankcharge',
                'amount' => $this->bankChargeAmount,
            ]);
        }

        $this->userPackage->payments()->createMany($data);

        $this->userPackage->user->notify((new AdditionalPaymentNotification($this->userPackage, $this->paymentMethod, $this->totalAmount + $this->bankChargeAmount)));

        $this->reset(['paymentMethod', 'bankId', 'currencyId', 'bankCharge', 'notes', 'amount', 'totalAmount']);

        $this->emitTo('user.additional-payment-history', 'updateAdditionalPaymentHistoryTable');

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Paid additional payment successfully.',
        ]);
    }

    public function render()
    {
        return view('livewire.user.additional-payment');
    }
}
