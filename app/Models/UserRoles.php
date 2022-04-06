<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoles extends Model
{
    //
    // use SoftDeletes;

    public function users(){
    	return $this->hasMany('App\Models\User');
    }

    public function access(){
        return $this->belongsToMany('App\Models\AccessLevels');
    }
}
