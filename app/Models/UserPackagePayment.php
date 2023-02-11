<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackagePayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'float',
        'bank_charge' => 'float',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function userPackage()
    {
        return $this->belongsTo(UserPackage::class, 'user_package_id', 'id')
            ->with([
                'user:id,country_id,name,email',
                'package:id,name',
                'user' => [
                    'country:id,name',
                ],
            ]);
    }
}
