<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservations extends Model
{
    //
    // use SoftDeletes;
    use HasFactory;

    public function guest(){
    	return $this->belongsTo('App\Models\Guests');
    }

    public function details(){
    	return $this->hasMany('App\Models\ReservationDetails','reservations_id');
    }

    public function rentals(){
    	return $this->hasMany('App\Models\ReservationRentals','reservations_id');
    }

    public function expenses(){
    	return $this->hasMany('App\Models\ReservationExpenses','reservations_id');
    }

    public function payments(){
    	return $this->hasMany('App\Models\Payments');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User','created_by');
    }

    public function company(){
    	return $this->belongsTo('App\Models\Company');
    }
}
