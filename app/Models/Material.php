<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = ['id'];

//    public function getImgUrlAttribute($v)
//    {
//        return getImgUrl($v);
//    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $model->img_url = getImgUrl($model->img_url);
        });
    }
}
