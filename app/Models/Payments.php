<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    //
    // use SoftDeletes;

    public function reservation(){
    	return $this->belongsTo('App\Models\Reservations');
    }

    public function sale(){
    	return $this->belongsTo('App\Models\ReservationDetails');
    }
}
