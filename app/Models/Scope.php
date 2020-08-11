<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function outTasks()
    {
        return $this->hasManyThrough(OutTaskUser::class, User::class, 'scope_id', 'user_id')->count();
    }

    public function outTaskCount()
    {

    }
}
