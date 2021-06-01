<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Completedlevel extends Model
{
    public $table = 'completedlevel';
      protected $fillable = [
      'user_id',
      'level_id',
      'topic_id',
    ];
}
