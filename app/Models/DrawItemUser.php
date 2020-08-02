<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrawItemUser extends Model
{
    protected $guarded = ['id'];

    public function draw()
    {
        return $this->belongsTo(Draw::class, 'draw_id');
    }

    public function draw_item()
    {
        return $this->belongsTo(DrawItem::class, 'draw_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verify_user()
    {
        return $this->belongsTo(User::class, 'verify_user_id');
    }
}
