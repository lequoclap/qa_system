<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\Topic;
use App\Models\Vote;
use Classes\Services\VoteService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DashboardController extends BaseController{

    const SORT_BY_TIME      = "created_time";
    const SORT_BY_UP_VOTE   = "up_vote";
    const SORT_BY_DOWN_VOTE = "down_vote";

    const ORDER_TYPE_ASC = "asc";
    const ORDER_TYPE_DESC = "desc";

    public function index()
    {

        $sort_by = Input::get('sort-by')? Input::get('sort-by') : self::SORT_BY_UP_VOTE;
        $order_type = Input::get('order-type')? Input::get('order-type') : self::ORDER_TYPE_DESC;


        $topic_dao = Topic::join('users', 'users.id', '=', 'user_id')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->select('topics.*', 'users.name as user_name', 'categories.name as category_name');
// Search tag
        if(Input::get('tags')){
            $tags = explode(',', Input::get('tags'));
            foreach ($tags as $tag){
                $topic_dao = $topic_dao->where('tags', 'LIKE', "%".$tag."%");
            }
        }
//Search term
        if(Input::get('search-term')){
            $search_term = Input::get('search-term');
            $topic_dao = $topic_dao->whereRaw(DB::raw("(title LIKE '%$search_term%' OR content LIKE '%$search_term%')"));
        }
        $topics = $topic_dao->get();

        $topics_data = Array();
        $setting = Array();

        $voteService = new VoteService();

        foreach ($topics as $topic){
            $topic_data = Array();
            $topic_data['topic'] = $topic;
            $topic_data['up_vote'] = $voteService->countTopicVote($topic->id, Vote::TYPE_VOTE_UP);
            $topic_data['down_vote'] = $voteService->countTopicVote($topic->id, Vote::TYPE_VOTE_DOWN);
            $topic_data['comment_count'] = $this->_countComment($topic->id);
            $topics_data[] = $topic_data;
        }

        switch ($sort_by){
            case self::SORT_BY_TIME:
                $topics_data = $this->_sortByTime($topics_data);
                break;
            case self::SORT_BY_UP_VOTE:
                $topics_data = $this->_sortByUpVote($topics_data);
                break;
            case self::SORT_BY_DOWN_VOTE:
                $topics_data = $this->_sortByDownVote($topics_data);
                break;
        }

        if($order_type == self::ORDER_TYPE_DESC){
            $topics_data = array_reverse($topics_data);
        }
        $setting['order_type'] = $order_type;

        return \View::make('dashboard.index', ['topics_data'=>$topics_data, 'setting' => $setting]);
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

    private function _countComment($topic_id){
        $count = Comment::where('topic_id', $topic_id)
            ->count();
        return $count;
    }
}