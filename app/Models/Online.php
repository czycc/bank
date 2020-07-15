<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Online extends Model
{
    protected $guarded = ['id'];

    public function getBannerAttribute($v)
    {
        return getImgUrl($v);
//        return $v;
    }
}
