<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteTaskUser extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function task()
    {
        return $this->belongsTo(InviteTask::class, 'invite_task_id');
    }
}
