<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'info' => 'json',
    ];

    public function getBackgroundAttribute($v) {
        return getImgUrl($v);
    }
}
