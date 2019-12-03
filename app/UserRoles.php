<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoles extends Model
{
    //
    use SoftDeletes;
    
    public function users(){
    	return $this->hasMany('App\User');
    }

    public function access(){
        return $this->belongsToMany('App\AccessLevels');
    }
}
