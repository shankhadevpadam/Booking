<?php

namespace App\Models;

use App\Builders\UserPackageBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UserPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'is_paid' => 'boolean',
        'arrival_date' => 'date:Y-m-d',
        'arrival_time' => 'date:H:i',
        'appointment_date' => 'date:Y-m-d',
        'appointment_time' => 'date:H:i',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($userPackage) {
            if ($userPackage->isForceDeleting()) {
                $userPackage->travelers()->each(function ($traveler) {
                    $traveler->delete();
                });

                $userPackage->invoices()->each(function ($invoice) {
                    Storage::disk('invoices')->delete("{$invoice->name}.pdf");
                });
            }
        });
    }

    public function newEloquentBuilder($query)
    {
        return new UserPackageBuilder($query);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function package()
    {
        return $this->belongsTo(Package::class)->withTrashed();
    }

    public function departure()
    {
        return $this->belongsTo(PackageDeparture::class)->withTrashed();
    }

    public function addons()
    {
        return $this->hasMany(UserPackageAddon::class);
    }

    public function groups()
    {
        return $this->hasMany(UserPackageGroup::class);
    }

    public function travelers()
    {
        return $this->hasMany(UserPackageTraveler::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(UserPackagePayment::class)->latestOfMany();
    }

    public function payments()
    {
        return $this->hasMany(UserPackagePayment::class);
    }

    public function agency()
    {
        return $this->hasOne(UserPackageAgency::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function addonPackages()
    {
        return $this->hasMany(UserPackageAddonPackage::class, 'user_package_id');
    }
}
