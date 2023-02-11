<?php

namespace App\Models;

use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Package extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'payment_type' => PaymentType::class,
        'addons' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($package) {
            if ($package->isForceDeleting()) {
                $package->addons()->each(function ($addon) {
                    $addon->delete();
                });
            }
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function departures()
    {
        return $this->hasMany(PackageDeparture::class);
    }

    public function addons()
    {
        return $this->hasMany(PackageAddon::class);
    }

    public function discounts()
    {
        return $this->hasMany(PackageGroupDiscount::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function userPackages()
    {
        return $this->hasMany(UserPackage::class);
    }
}
