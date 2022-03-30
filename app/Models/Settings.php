<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    //
    public function user(){
    	return $this->belongsTo('App\Models\User','created_by');
    }
}
