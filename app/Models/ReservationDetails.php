<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationDetails extends Model
{
    //
    // use SoftDeletes;
    use HasFactory;

    public function reservation(){
    	return $this->belongsTo('App\Models\Reservations','reservations_id');
    }

    public function room(){
    	return $this->belongsTo('App\Models\Rooms');
    }
    public function roomtype(){
    	return $this->belongsTo('App\Models\RoomTypes','room_type_id');
    }
}
