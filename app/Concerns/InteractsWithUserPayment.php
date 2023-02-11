<?php

namespace App\Concerns;

use App\Models\Coupon;
use App\Models\PackageDeparture;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait InteractsWithUserPayment
{
    private $data;

    private string $uuid;

    public User $user;

    public UserPackage $userPackage;

    public function setData(string $token): self
    {
        $this->data = (object) Cache::get($token);

        Cache::forget($token);

        return $this;
    }

    public function getCacheByKey(string $token, string $key): ?string
    {
        $data = (object) Cache::get($token);

        return $data->{$key} ?? null;
    }

    public function getUser(): self
    {
        if ($this->data->user_id) {
            $this->user = User::find($this->data->user_id);
        } else {
            $this->user = auth()->user();
        }

        return $this;
    }

    public function createUser(): self
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
            'total_amount' => $this->data->total_amount,
            'payment_status' => $this->data->payment_option,
            'is_paid' => ($this->data->payment_option === 'deposit' || $this->data->payment_option === 'full') ? true : false,
        ]);

        $this->storeAddonToUserPackage($userPackage);

        $this->storeAddonPackageToUserPackage($userPackage);

        $this->userPackage = $userPackage;

        return $this;
    }

    public function storeAddonToUserPackage(UserPackage $userPackage): void
    {
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
    }

    public function storeAddonPackageToUserPackage(UserPackage $userPackage): void
    {
        if ($this->data->addon_packages) {
            foreach ($this->data->addon_packages as $addon) {
                $userPackage->addonPackages()->create([
                    'name' => $addon['name'],
                    'number_of_days' => $addon['number_of_days'],
                    'price' => $addon['price'],
                ]);
            }
        }
    }

    public function createPayment(float $amount, $paymentMethod = 'credit_card', $userPackageId = null, $paymentType = null): self
    {
        UserPackagePayment::create([
            'user_package_id' => $userPackageId ?? $this->userPackage->id,
            'currency_id' => setting('currency_id'),
            'bank_id' => setting('payment_method') == 'card' ? setting('bank_id') : null,
            'payment_method' => $paymentMethod,
            'payment_type' => $paymentType ?? $this->data->payment_option,
            'amount' => $amount - $this->data->bank_charge,
            'bank_charge' => $this->data->bank_charge ?? 0,
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

    public function adjustDepartureQuantity(): self
    {
        PackageDeparture::where('id', $this->data->departure_id)->increment('sold_quantity', $this->data->number_of_trekkers);

        return $this;
    }

    public function getPackageDeparture(): PackageDeparture
    {
        return PackageDeparture::find($this->data->departure_id);
    }

    public function ensureCouponApplied(): void
    {
        if (isset($this->data->redeem_applied) && $this->data->redeem_applied === true) {
            Coupon::where('code', $this->data->redeem_code)->decrement('limit');
        }
    }

    public function formatAmount(string $amount): float
    {
        $amount = ltrim($amount, '0');

        return $amount / 100;
    }
}
