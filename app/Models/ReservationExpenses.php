<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationExpenses extends Model
{
    //
    // use SoftDeletes;
    use HasFactory;

    public function reservation(){
    	return $this->belongsTo('App\Models\Reservations','reservations_id');
    }
}
