<?php

namespace Magical\Payment\Traits;

use App\Models\Coupon;
use App\Models\PackageDeparture;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait PaymentTrait
{
    private $data;

    private string $uuid;

    public User $user;

    public UserPackage $userPackage;

    public function setData(string $token)
    {
        $this->data = (object) Cache::get($token);

        Cache::forget($token);

        return $this;
    }

    public function registerUser(): self
    {
        $this->uuid = Str::uuid();

        $user = User::create([
            'name' => $this->data->name,
            'email' => $this->data->email,
            'password' => $this->data->password,
            'is_admin' => false,
            'country_id' => $this->data->country_id,
            'email_verified_at' => now(),
            'token' => $this->uuid,
        ]);

        $user->assignRole('Client');

        $this->user = $user;

        return $this;
    }

    public function makeDeparture(): self
    {
        $this->ensureCouponApplied();

        $userPackage = $this->user->userPackage()->create([
            'package_id' => $this->data->package_id,
            'departure_id' => $this->data->departure_id,
            'number_of_trekkers' => $this->data->number_of_trekkers,
            'start_date' => $this->getPackageDeparture()->start_date,
            'end_date' => $this->getPackageDeparture()->end_date,
            'total_amount' => $this->data->total,
            'payment_status' => $this->data->payment_option,
            'is_paid' => true,
        ]);

        if ($this->data->addons) {
            foreach ($this->data->addons as $addon) {
                if ($addon['count'] > 0) {
                    $userPackage->addons()->create([
                        'name' => $addon['name'],
                        'count' => $addon['count'],
                        'price' => $addon['price'],
                    ]);
                }
            }
        }

        $this->userPackage = $userPackage;

        return $this;
    }

    public function createPayment(float $amount, $paymentMethod = 'card'): self
    {
        UserPackagePayment::create([
            'user_package_id' => $this->userPackage->id,
            'currency_id' => setting('currency_id'),
            'bank_id' => setting('payment_method') === 'card' ? setting('bank_id') : null,
            'payment_method' => $paymentMethod,
            'payment_type' => $this->data->payment_option,
            'amount' => $amount,
        ]);

        return $this;
    }

    public function getQueryString(): string
    {
        $queryString = http_build_query([
            'pid' => $this->data->package_id,
            'did' => $this->data->departure_id,
            'step' => 2,
            'token' => $this->uuid,
        ]);

        return $queryString;
    }

    public function getPackageDeparture(): PackageDeparture
    {
        return PackageDeparture::find($this->data->departure_id);
    }

    public function ensureCouponApplied(): void
    {
        if ($this->data->redeem_applied === true) {
            Coupon::where('code', $this->data->redeem_code)->decrement('limit');
        }
    }

    public function formatAmount(string $amount): float
    {
        $amount = ltrim($amount, '0');

        return $amount / 100;
    }
}
