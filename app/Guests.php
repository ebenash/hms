<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guests extends Model
{
    //
	use SoftDeletes;

    public function reservations(){
    	return $this->hasMany('App\Reservations');
    }
}
