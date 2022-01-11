<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLevels extends Model
{
    //
    public function roles(){
        return $this->belongsToMany('App\Models\UserRoles');
    }
}
