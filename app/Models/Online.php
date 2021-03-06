<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Online extends Model
{
    protected $guarded = ['id'];

//    public function getBannerAttribute($v)
//    {
//        return getImgUrl($v);
////        return $v;
//    }

    protected $casts = [
        'end' => 'datetime'
    ];

    public function getEndDateAttribute()
    {
        return Carbon::create($this->end)->toDateString();
    }

    public function category()
    {
        return $this->belongsTo(OnlineCategory::class, 'category_id');
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class, 'scope_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $model->banner = getImgUrl($model->banner);
        });
    }
}
