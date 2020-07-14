<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = ['id'];

    public function getImgUrlAttribute($v)
    {
        return getImgUrl($v);
    }
}
