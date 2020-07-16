<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'info' => 'json',
    ];

    public function getInfoAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setInfoAttribute($value)
    {
        $this->attributes['info'] = json_encode(array_values($value));
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

//            $old_content = $this->getCAttribute();
//            foreach ($content as $key => &$val) { // 如果旧数据未删除，且当前不存在图片，则将旧图片路径添加进去
//                if (isset($old_content[$key]) && !isset($val['image']))
//                { $val['image'] = $old_content[$key]['image']; } } $this->attributes['content'] = json_encode(array_values($content));

                $model->background = getImgUrl($model->background);
                $arr = $model->info;
                foreach ($arr as $key => $v) {
                    $arr[$key]['reward_bg'] = getImgUrl($v['reward_bg']);
                }
                $model->info = $arr;
            });
        }
}
