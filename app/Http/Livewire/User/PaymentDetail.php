<?php

namespace App\Http\Livewire\User;

use App\Models\Bank;
use App\Models\Currency;
use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use Livewire\Component;

class PaymentDetail extends Component
{
    public UserPackage $userPackage;

    public string $paymentOption = 'cash';

    public string $currencyId = '';

    public ?string $bankId = null;

    public string $exchangeAmount;

    public ?string $notes = null;

    public float $totalPackageAmount = 0;

    public float $totalBankChargeAmount = 0;

    public float $totalAdvancedAmount = 0;

    public float $totalRemainingAmount = 0;

    public float $totalPaidAmount = 0;

    public float $totalRemainingBankChargeAmount = 0;

    public float $totalRemainingAfterBankChargeAmount = 0;

    protected $listeners = ['updateTotal', 'payRemainingAmount'];

    public function mount()
    {
        $this->totalPackageAmount = $this->userPackage->total_amount;

        $this->totalAdvancedAmount = $this->totalAdvancedAmount();

        $this->totalBankChargeAmount = $this->totalBankChargeAmount();

        $this->totalPaidAmount = $this->totalAdvancedAmount() + $this->totalBankChargeAmount();

        $this->totalRemainingAmount = $this->userPackage->total_amount - $this->totalAdvancedAmount;

        $this->totalRemainingBankChargeAmount = $this->paymentOption == 'cash' ? 0 : $this->totalRemainingAmount * setting('bank_charge', 0) / 100;

        $this->totalRemainingAfterBankChargeAmount = $this->totalRemainingAmount + $this->totalRemainingBankChargeAmount;
    }

    public function totalAdvancedAmount()
    {
        $filteredPayments = $this->userPackage->payments->filter(function ($item) {
            return !(str_contains($item->payment_type, 'additional') || str_contains($item->payment_type, 'refund'));
        });

        return $filteredPayments->sum('amount');
    }

    public function totalBankChargeAmount()
    {
        return $this->userPackage->payments->sum('bank_charge');
    }

    public function updateTotal()
    {
        $this->paymentOption = 'cash';

        $this->totalPackageAmount = $this->userPackage->total_amount;

        $this->totalRemainingAmount = $this->userPackage->total_amount - $this->totalAdvancedAmount;

        $this->totalRemainingBankChargeAmount = round($this->totalRemainingAmount * setting('bank_charge', 0) / 100, 2);

        $this->totalRemainingAfterBankChargeAmount = $this->totalRemainingAmount + $this->totalRemainingBankChargeAmount;
    }

    public function setPaymentOption()
    {
        if (in_array($this->paymentOption, ['wise', 'cash', 'pos'])) {
            $this->totalRemainingBankChargeAmount = 0;
        } else {
            $this->totalRemainingBankChargeAmount = round($this->totalRemainingAmount * setting('bank_charge', 0) / 100, 2);
        }

        $this->totalRemainingAfterBankChargeAmount = $this->totalRemainingAmount + $this->totalRemainingBankChargeAmount;
    }

    public function setBankId()
    {
        if (! $this->bankId) {
            $this->totalRemainingBankChargeAmount = 0;
        } else {
            $this->bankId = $this->bankId;
            $bank = Bank::find($this->bankId);
            $this->totalRemainingBankChargeAmount = $this->totalRemainingAmount * $bank->charge / 100;
        }

        $this->totalRemainingAfterBankChargeAmount = $this->totalRemainingAmount + $this->totalRemainingBankChargeAmount;
    }

    public function payRemainingAmount()
    {
        if ($this->paymentOption === 'cash') {
            $this->validate([
                'currencyId' => ['required'],
                'exchangeAmount' => ['required', 'numeric'],
            ]);
        }

        if ($this->paymentOption === 'pos') {
            $this->validate([
                'currencyId' => ['required'],
                'bankId' => ['required'],
            ]);
        }

        $this->createPayment();

        $route = auth()->user()->is_admin ? 'admin.clients.package.show' : 'package.departure';

        return redirect()
            ->route($route, $this->userPackage)
            ->with('success', 'Your payment is successfully paid.');
    }

    private function createPayment(): void
    {
        UserPackagePayment::create([
            'user_package_id' => $this->userPackage->id,
            'currency_id' => $this->currencyId ? $this->currencyId : 1,
            'bank_id' => $this->bankId,
            'payment_method' => $this->paymentOption,
            'payment_type' => 'overdue',
            'amount' => $this->totalRemainingAmount,
            'bank_charge' => $this->totalRemainingBankChargeAmount,
            'exchange_amount' => $this->paymentOption === 'cash' ? $this->exchangeAmount : 0,
            'notes' => $this->paymentOption === 'cash' ? $this->notes : NULL,
        ]);
    }

    public function render()
    {
        return view('livewire.user.payment-detail', [
            'currencies' => Currency::toBase()->get(),
            'banks' => Bank::toBase()->get(),
        ]);
    }
}
