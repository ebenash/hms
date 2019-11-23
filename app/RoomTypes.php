<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomTypes extends Model
{
    //
    use SoftDeletes;
    
    public function rooms(){
    	return $this->hasMany('App\Rooms');
    }
}
