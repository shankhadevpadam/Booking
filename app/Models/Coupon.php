<?php

namespace App\Models;

use App\Enums\DiscountApply;
use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'discount_type' => DiscountType::class,
        'discount_apply_on' => DiscountApply::class,
        'expire_date' => 'date:Y-m-d',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
