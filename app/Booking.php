<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'admin_id','guest_id', 'date','room', 'bill','remarks'
    ];
}
