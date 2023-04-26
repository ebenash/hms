<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class PaystackInvoices extends Model
{
    //
    // use SoftDeletes;

    public function guest(){
    	return $this->belongsTo('App\Models\Guests','customer','paystack_identifier');
    }

    public function reservation(){
    	return $this->belongsTo('App\Models\Reservations');
    }
}
