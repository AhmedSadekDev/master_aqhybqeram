<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $table = "rates";

    protected $fillable = [
        'user_id',
        'store_id',
        'rate',
        'message',
    ];

    public function user() {
        return $this->hasOne(\App\Models\User::class,'id','user_id');
    }

    public function store() {
        return $this->hasOne(\App\Models\Store::class,'id','store_id');
    }
}
