<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'info' => 'json',
    ];

//    public function getInfoAttribute($value)
//    {
//        return array_values(json_decode($value, true) ?: []);
//    }
//
//    public function setInfoAttribute($value)
//    {
//        $this->attributes['info'] = json_encode(array_values($value));
//    }

    public function items()
    {
        return $this->hasMany(DrawItem::class, 'draw_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $model->background = getImgUrl($model->background);

        });
    }
}
