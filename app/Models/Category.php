<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = [
        'name',
        'image',
        'active',
    ];

    public function stores() {
        return $this->belongsToMany(\App\Models\Store::class, 'category_stores_pivot', 'category_id' ,'store_id');
    }

    public function showStatus() {
        if($this->active == 0) {
            return '<span class="make_pad badge bg-danger">'.__("Inactive").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("Active").'</span>';
        }
    }
}
