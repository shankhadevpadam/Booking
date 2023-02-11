<?php

namespace App\Models;

use App\Enums\DiscountApply;
use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageDeparture extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'discount_type' => DiscountType::class,
        'discount_apply_on' => DiscountApply::class,
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function isExpired()
    {
        return $this->where('start_date', '>', today()->format('Y-m-d'))->doesntExist();
    }

    public function isAvailable()
    {
        return $this->sold_quantity !== $this->total_quantity ? true : false;
    }
}
