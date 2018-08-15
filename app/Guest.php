<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{


    protected $fillable = [
        'admin_id','name', 'mail','totalPrice', 'phone','nid', 'address','gender','dob'
    ];

    public function admin()
    {
       return $this->belongsTo('App\User','admin_id');
    }
}
