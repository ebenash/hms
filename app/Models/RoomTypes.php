<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class RoomTypes extends Model
{
    //
    // use SoftDeletes;

    public function rooms(){
    	return $this->hasMany('App\Models\Rooms', 'room_type_id');
    }
}
