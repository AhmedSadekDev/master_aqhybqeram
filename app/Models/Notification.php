<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "notifications";

    protected $fillable = [
        'user_id',
        'model_id',
        'title',
        'message',
        'type',
        'users',
    ];
    
    protected $casts = [
        'users' => 'array',
    ];

    public function showMessage() {
        if($this->type == "admin") {
            return $this->message;
        } elseif($this->type == "coupon") {
            $store = '------';
            $coupon = Coupon::find($this->model_id);
            if(!is_null($coupon)) {
                $store = $coupon->store->name ?? '-----';
            }
            return __('Created New Coupon On Store :STORE',["STORE"=>$store]);
        } elseif($this->type == "subscription") {
            $subscription = Subscription::find($this->model_id)->name ?? '';
            return __('Oops, your subscription has been end :SUBSCRIPTION',["SUBSCRIPTION"=>$subscription]);
        }
        return '--';
    }

}
