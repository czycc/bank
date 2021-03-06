<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitTaskUser extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(VisitTask::class, 'visit_task_id');
    }
}
