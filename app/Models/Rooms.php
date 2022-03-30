<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Rooms extends Model
{
    //
    // use SoftDeletes;

    public function roomtype(){
    	return $this->belongsTo('App\Models\RoomTypes', 'room_type_id');
    }

    public function reservations(){
    	return $this->hasMany('App\Models\Reservations','room_id');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User','created_by');
    }
}
