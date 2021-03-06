<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    //
    use SoftDeletes;
    
    public function reservation(){
    	return $this->belongsTo('App\Reservations');
    }
}
