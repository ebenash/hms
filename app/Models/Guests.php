<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guests extends Model
{
    //
	// use SoftDeletes;
    use HasFactory;

    public function reservations(){
    	return $this->hasMany('App\Models\Reservations');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User','created_by');
    }
}
