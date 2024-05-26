<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = "stores";

    protected $fillable = [
        'name',
        'logo',
        'cover',
        'desc',
        'active',
        'rate',
        'offer',
        'more_choice',
        'recommend',
        'unmissable_offer',
    ];

    public function categories() {
        return $this->belongsToMany(\App\Models\Category::class, 'category_stores_pivot', 'store_id', 'category_id');
    }

    public function coupons() {
        return $this->hasMany(\App\Models\Coupon::class, 'store_id' ,'id');
    }

    public function getRates() {
        return $this->hasMany(\App\Models\Rate::class, 'store_id' ,'id');
    }

    public function showStatus() {
        if($this->active == 0) {
            return '<span class="make_pad badge bg-danger">'.__("Inactive").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("Active").'</span>';
        }
    }

    public function showOffer() {
        if($this->offer == 0) {
            return '<span class="make_pad badge bg-danger">'.__("ليس بعرض").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("عرض").'</span>';
        }
    }

    public function showMoreChoice() {
        if($this->more_choice == 0) {
            return '<span class="make_pad badge bg-danger">'.__("ليس اكتر اختيار").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("اكتر اختيار").'</span>';
        }
    }

    public function showRecommend() {
        if($this->recommend == 0) {
            return '<span class="make_pad badge bg-danger">'.__("غير موصي").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("موصي به").'</span>';
        }
    }

    public function showUnmissableOffer() {
        if($this->unmissable_offer == 0) {
            return '<span class="make_pad badge bg-danger">'.__("غير نشط").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("نشط").'</span>';
        }
    }
}
