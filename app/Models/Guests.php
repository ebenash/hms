<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Guests extends Model
{
    //
	// use SoftDeletes;

    public function reservations(){
    	return $this->hasMany('App\Models\Reservations');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User','created_by');
    }
}
