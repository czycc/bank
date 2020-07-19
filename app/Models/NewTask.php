<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewTask extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime'
    ];
}
