<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewTaskUser extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(NewTask::class, 'new_task_id');
    }
}
