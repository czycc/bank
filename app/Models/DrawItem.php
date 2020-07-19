<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrawItem extends Model
{
    protected $guarded = ['id'];

    public function draw()
    {
        return $this->belongsTo(Draw::class, 'draw_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $model->reward_bg = getImgUrl($model->reward_bg);

        });
    }
}
