<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','last_name', 'email', 'password', 'mobile','hospital_name', 'address', 'city', 'role','status',
        'device_id','device_type','device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at',
    ];


    public function answers() {
      return $this->hasOne('App\Answer');
    }

    public function topic() {
      return $this->belongsToMany('App\Topic','topic_user')
        ->withPivot('amount','transaction_id','status')
        ->withTimestamps();
    }

    public function is_admin() {
      if (Auth::check()) {
        if (Auth::user()->role == 'A') {
          return true;
        }
        return false;
      }
      return false;
    }
}
