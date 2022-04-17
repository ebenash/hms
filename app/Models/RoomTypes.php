<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomTypes extends Model
{
    //
    // use SoftDeletes;
    use HasFactory;

    public function rooms(){
    	return $this->hasMany('App\Models\Rooms','room_type_id');
    }
}
