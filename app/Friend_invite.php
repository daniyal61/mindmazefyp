<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Topic;
class Friend_invite extends Model
{
    protected $table = 'friend_invites';
     public $timestamps = false;

     public function user()
    {
        return $this->hasOne(User::class , 'id', 'user_id');
    }

    public function topic()
    {
        return $this->hasOne(Topic::class , 'id', 'topic_id');
    }
}
