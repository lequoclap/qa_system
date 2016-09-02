<?php

/**
 * Created by PhpStorm.
 * User: laplq
 * Date: 2016/08/28
 * Time: 17:05
 */

namespace Classes\Services;

use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Topic;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class TopicService
{

    const SORT_BY_TIME      = "created_time";
    const SORT_BY_UP_VOTE   = "up_vote";
    const SORT_BY_DOWN_VOTE = "down_vote";

    const ORDER_TYPE_ASC = "asc";
    const ORDER_TYPE_DESC = "desc";

    protected $user;

    public function __construct($user = null){
        if($user){
            $this->user = $user;
        }else {
            $this->user = Auth::user();
        }
    }

    public function getTopicList($extra = Array()){

        $search_term = isset($extra['search_term']) ? $extra['search_term']: null;
        $tags = isset($extra['tags']) ? $extra['tags']: null;
        $sort_by = isset($extra['sort_by']) ? $extra['sort_by']: self::SORT_BY_TIME;
        $order_type = isset($extra['order_type']) ? $extra['order_type']: self::ORDER_TYPE_DESC;
        $category_id = isset($extra['category']) ? $extra['category']: null;
        $user_id = isset($extra['user']) ? $extra['user']: null;

        $topic_dao = Topic::join('users', 'users.id', '=', 'user_id')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->select('topics.*', 'users.name as user_name', 'categories.name as category_name');

        // Search tag
        if($tags){
            $tags_arr = explode(',', $tags);
            foreach ($tags_arr as $tag){
                $topic_dao = $topic_dao->where('tags', 'LIKE', "%".$tag."%");
            }
        }
        //Search term
        if($search_term){
            $topic_dao = $topic_dao->whereRaw(DB::raw("(title LIKE '%$search_term%' OR content LIKE '%$search_term%')"));
        }

        //Search user_id
        if($user_id){
            $topic_dao = $topic_dao->where('user_id', $user_id);
        }
        //Search category_id
        if($category_id){
            $topic_dao = $topic_dao->where('category_id', $category_id);
        }


        $topics = $topic_dao->get();

        $topics_data = Array();
        $voteService = new VoteService();

        foreach ($topics as $topic){
            $topic_data = Array();
            $topic_data['topic'] = $topic;
            $topic_data['up_vote'] = $voteService->countTopicVote($topic->id, Vote::TYPE_VOTE_UP);
            $topic_data['down_vote'] = $voteService->countTopicVote($topic->id, Vote::TYPE_VOTE_DOWN);
            $topic_data['comment_count'] = $this->_countComment($topic->id);
            $topics_data[] = $topic_data;
        }

        //Sort By
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
        //Order By
        if($order_type == self::ORDER_TYPE_DESC){
            $topics_data = array_reverse($topics_data);
        }

        return $topics_data;

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

    public function getSortByList(){
        $arr = [
            self::SORT_BY_TIME => "Created time",
            self::SORT_BY_UP_VOTE => "Up vote",
            self::SORT_BY_DOWN_VOTE => "Down vote",
        ];
        return $arr;

    }

}