<?php


namespace App\Http\Controllers;


use App\Http\Requests\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class VoteController extends BaseController
{

    public function createVote()
    {
        $user = Auth::user();

        $target = Input::get('target');
        $id = Input::get('id');
        $vote_type = Input::get('vote_type');

        if ($target == Vote::TARGET_TOPIC){
            $col_id = 'topic_id';
        }else if($target == Vote::TARGET_COMMENT){
            $col_id = 'comment_id';
        }
        $vote = Vote::where('user_id', $user->id)
            ->where('target', $target)
            ->where($col_id, $id)
            ->first();

        if(!$vote){
            $vote = new Vote();
            $vote->target = $target;
            $vote->$col_id = $id;
            $vote->user_id = $user->id;
        }

        $vote->type = $vote_type;
        $vote->save();

    }

    public function deleteVote(){
        $user = Auth::user();

        $target = Input::get('target');
        $id = Input::get('id');

        if ($target == Vote::TARGET_TOPIC){
            $col_id = 'topic_id';
        }else if($target == Vote::TARGET_COMMENT){
            $col_id = 'comment_id';
        }

        $vote = Vote::where('user_id', $user->id)
            ->where('target', $target)
            ->where($col_id, $id)
            ->first();
        $vote->delete();


    }

}