<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $table = "user_subscriptions";

    protected $fillable = [
        'user_id',
        'subscription_id',
        'start',
        'end',
        'price',
        'payment_id',
        'payment_status',
        'active',
    ];

    public function user() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }

    public function subscription() {
        return $this->hasOne(\App\Models\Subscription::class, 'id', 'subscription_id');
    }

    public function showStatus() {
        if($this->active == 0) {
            return '<span class="make_pad badge bg-danger">'.__("Inactive").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("Active").'</span>';
        }
    }
}
