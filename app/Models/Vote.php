<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Vote extends Model
{

    const TYPE_VOTE_UP = 1;
    const TYPE_VOTE_DOWN = 2;

    const TARGET_COMMENT = 'target_comment';
    const TARGET_TOPIC = 'target_topic';
    
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}