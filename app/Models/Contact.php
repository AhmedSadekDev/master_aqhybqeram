<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = "contacts";

    protected $fillable = [
        'name',
        'email',
        'message',
        'seen',
    ];

    public function showStatus() {
        if($this->seen == 0) {
            return '<span class="make_pad badge bg-danger">'.__("Unseen").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("Seen").'</span>';
        }
    }
}
