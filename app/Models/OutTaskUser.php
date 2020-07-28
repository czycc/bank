<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutTaskUser extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(OutTask::class, 'out_task_id');
    }
}
