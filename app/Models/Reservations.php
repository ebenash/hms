<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservations extends Model
{
    //
    use SoftDeletes;

    public function guest(){
    	return $this->belongsTo('App\Models\Guests');
    }

    public function payments(){
    	return $this->hasMany('App\Models\Payments');
    }

    public function room(){
    	return $this->belongsTo('App\Models\Rooms');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User','created_by');
    }
}
