<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
      'title', 'per_q_mark', 'level', 'description', 'timer','show_ans','amount','quiz_code',
    ];

    public function question(){
      return $this->hasMany('App\Question','topic_id');
    }

    public function answer(){
      return $this->hasOne('App\Answer');
    }
    
    public function user() {
      return $this->belongsToMany('App\User','topic_user')
         ->withPivot('amount','transaction_id', 'status')
        ->withTimestamps();
    }
}
