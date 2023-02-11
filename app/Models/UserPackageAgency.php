<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackageAgency extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id', 'id');
    }

    public function userPackage()
    {
        return $this->belongsTo(UserPackage::class);
    }
}
