<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE_ADMIN    = "admin";
    const TYPE_CUSTOMER = "customer";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'phone_verified_at',
        'password',
        'activated_code',
        'api_token',
        'dev_token',
        'user_type',
        'completed_data',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_hash',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function phoneVerified() {
        if(is_null($this->phone_verified_at)) {
            return '<span class="make_pad badge bg-danger">'.__("غير مفعل").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("مفعل").'</span>';
        }
    }

    public function completedData() {
        if(is_null($this->completed_data)) {
            return '<span class="make_pad badge bg-danger">'.__("غير مكتمل").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("مكتمل").'</span>';
        }
    }

    public function subscriptions() {
        return $this->hasMany(\App\Models\User\UserSubscription::class,'user_id','id');
    }

    public function fav() {
        return $this->belongsToMany(\App\Models\Store::class, 'stores_fav', 'user_id' ,'store_id');
    }
}
