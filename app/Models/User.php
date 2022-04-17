<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    // use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'company_id', 'email', 'phone', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(\Spatie\Permission\Models\Role::class);
    }

    public function company(){
        return $this->belongsTo('App\Models\Company');
    }

    public function reservations(){
        return $this->hasMany('App\Models\Reservations','created_by');
    }

    public function rooms(){
        return $this->hasMany('App\Models\Rooms','created_by');
    }

    public function guests(){
        return $this->hasMany('App\Models\Guests','created_by');
    }

    public function settings(){
        return $this->hasOne('App\Models\Settings','created_by');
    }
}
