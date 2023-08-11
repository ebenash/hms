<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    //
    public function payments(){
    	return $this->hasMany('App\Models\Payments','payment_type_id')->where('payments.payment_type', '=', 'reservation');
    }
}
