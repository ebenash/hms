<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservations extends Model
{
    //
    use SoftDeletes;
    
    public function guest(){
    	return $this->belongsTo('App\Guests');
    }

    public function payments(){
    	return $this->hasMany('App\Payments');
    }

    public function room(){
    	return $this->belongsTo('App\Rooms');
    }
}
