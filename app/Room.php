<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'admin_id','name', 'number','rent', 'guest','remarks', 'status'
    ];

}