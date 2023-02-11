<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Billable, HasApiTokens, HasFactory, HasRoles, Notifiable, InteractsWithMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'email_verified_at',
        'is_admin',
        'type',
        'approved_at',
        'country_id',
        'password',
        'token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->isForceDeleting()) {
                $user->reviews()->each(function ($review) {
                    $review->delete();
                });

                $user->userPackageTravelers()->each(function ($traveler) {
                    $traveler->delete();
                });
            }
        });
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function routeNotificationForSparrowSMS()
    {
        return $this->phone;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
              ->width(100)
              ->height(100);
    }

    public function isAdmin()
    {
        return $this->is_admin ? true : false;
    }

    public function userPackage()
    {
        return $this->hasMany(UserPackage::class);
    }

    public function latestUserPackage()
    {
        return $this->hasOne(UserPackage::class)->latestOfMany();
    }

    public function userPackageTravelers()
    {
        return $this->hasManyThrough(
            UserPackageTraveler::class,
            UserPackage::class,
            'user_id',
            'user_package_id'
        );
    }

    public function userPackagePayments()
    {
        return $this->hasManyThrough(
            UserPackagePayment::class,
            UserPackage::class,
            'user_id',
            'user_package_id'
        );
    }

    public function userPackageInvoices()
    {
        return $this->hasManyThrough(
            UserPackageInvoice::class,
            UserPackage::class,
            'user_id',
            'user_package_id'
        );
    }

    public function userPackageAgencies()
    {
        return $this->hasOneThrough(
            UserPackageAgency::class,
            UserPackage::class,
            'user_id',
            'user_package_id'
        );
    }

    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault([
            'id' => 226,
            'name' => 'UNITED STATES',
        ]);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function photographUrl(bool $thumbnail = false)
    {
        if ($thumbnail) {
            return $this->getFirstMediaUrl('avatar', 'thumbnail') ?? null;
        }

        return $this->getFirstMediaUrl('avatar') ?? null;
    }

    public function adminlte_profile_url()
    {
        if ($this->is_admin) {
            return 'admin/profile';
        }

        return 'profile';
    }
}
