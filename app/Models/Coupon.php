<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = "coupons";

    protected $fillable = [
        'store_id',
        'name',
        'desc',
        'code',
        'expire',
    ];

    public function store() {
        return $this->hasOne(\App\Models\Store::class, 'id','store_id');
    }
}
