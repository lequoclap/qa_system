<?php

namespace App\Http\Controllers;


use App\Models\Topic;
use App\Models\Vote;
use Classes\Services\VoteService;

class DashboardController extends BaseController{

    public function index()
    {
        $topics = Topic::join('users', 'users.id', '=', 'user_id')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->select('topics.*', 'users.name as user_name', 'categories.name as category_name')
            ->get();
        $topics_data = Array();
        $voteService = new VoteService();

        foreach ($topics as $topic){
            $topic_data = Array();
            $topic_data['topic'] = $topic;
            $topic_data['up_vote'] = $voteService->countTopicVote($topic->id, Vote::TYPE_VOTE_UP);
            $topic_data['down_vote'] = $voteService->countTopicVote($topic->id, Vote::TYPE_VOTE_DOWN);
            $topics_data[] = $topic_data;
        }

        return \View::make('dashboard.index', ['topics_data'=>$topics_data]);
    }


    private function _sortByTime($array){
        $array = array_values(array_sort($array, function ($value) {
            return $value['topic']->created_at;
        }));
        return $array;
    }

    private function _sortByUpVote($array){
        $array = array_values(array_sort($array, function ($value) {
            return $value['up_vote'];
        }));
        return $array;
    }

    private function _sortByDownVote($array){
        $array = array_values(array_sort($array, function ($value) {
            return $value['down_vote'];
        }));
        return $array;
    }

    private function _reverseData($array){
        $array = array_reverse($array);
        return $array;
    }


}