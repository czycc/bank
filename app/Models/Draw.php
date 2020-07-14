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

    public function getInfoAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setInfoAttribute($value)
    {
        $this->attributes['info'] = json_encode(array_values($value));
    }
}
