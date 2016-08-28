<?php

/**
 * Created by PhpStorm.
 * User: laplq
 * Date: 2016/08/28
 * Time: 17:05
 */

namespace Classes\Services;

use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteService
{

    protected $user;

    public function __construct($user = null){
        if($user){
            $this->user = $user;
        }else {
            $this->user = Auth::user();
        }
    }


    public function countTopicVote($topic_id, $vote_type){
        $vote_count = Vote::where('target', Vote::TARGET_TOPIC)
            ->where('topic_id', $topic_id)
            ->where('type', $vote_type)
            ->count();
        return $vote_count;
    }

    public function countCommentVote($comment_id,$vote_type){
        $vote_count = Vote::where('target', Vote::TARGET_COMMENT)
            ->where('comment_id', $comment_id)
            ->where('type', $vote_type)
            ->count();
        return $vote_count;
    }

    public function isVoted($target, $vote_type, $id){
        if ($target == Vote::TARGET_TOPIC){
            $col_id = 'topic_id';
        }else if($target == Vote::TARGET_COMMENT){
            $col_id = 'comment_id';
        }

        $vote = Vote::where('target', $target)
            ->where($col_id, $id)
            ->where('type', $vote_type)
            ->where('user_id', $this->user->id)
            ->first();

        return isset($vote)? true:false;
    }

}