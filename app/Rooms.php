<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rooms extends Model
{
    //
    use SoftDeletes;
    
    public function roomtype(){
    	return $this->belongsTo('App\RoomTypes', 'room_type_id');
    }

    public function reservations(){
    	return $this->hasMany('App\Reservations');
    }
}
