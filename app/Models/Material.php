<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = ['id'];

    public function getImgUrlAttribute($v) {
        if (filter_var($v, FILTER_VALIDATE_URL)) {
            return $v;
        } elseif (!is_null($v)) {
            return asset($v);
        }
    }
}
