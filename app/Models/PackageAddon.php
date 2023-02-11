<?php

namespace App\Models;

use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PackageAddon extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'price' => 'float',
        'discount_type' => DiscountType::class,
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'addon_package_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_picture')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
              ->width(100)
              ->height(100);
    }
}
