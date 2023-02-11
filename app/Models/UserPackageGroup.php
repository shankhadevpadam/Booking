<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackageGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'arrival_date' => 'date:Y-m-d',
        'arrival_time' => 'date:H:i',
    ];
}
