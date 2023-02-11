<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Review extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
              ->width(100)
              ->height(100);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id')->withDefault();
    }

    public function scopePopular($query)
    {
        return $query->where(function ($query) {
            $query->where('is_published', true);
            $query->where('rating', 5);
        });
    }

    public function scopePublishedByPackageId($query, int $packageId)
    {
        return $query->where(function ($query) use ($packageId) {
            $query->where('package_id', $packageId);
            $query->where('is_published', true);
        });
    }
}
