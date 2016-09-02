<?php

namespace App\Http\Controllers;

use Classes\Services\TopicService;

use Illuminate\Support\Facades\Input;

class CategoryController extends BaseController{



    public function listTopics($id)
    {
        $extra = Array();
        $extra['sort_by'] = Input::get('sort-by');
        $extra['order_type'] = Input::get('order-type');
        $extra['search_term'] = Input::get('search-term');
        $extra['tags'] =Input::get('tags');
        $extra['category'] =$id;


        $topicService = new TopicService();
        $topics_data  = $topicService->getTopicList($extra);

        $setting = Array();
        $setting['order_type'] = $extra['order_type'];
        $setting['sort_by'] = $extra['sort_by'];
        $setting['sort_by_list'] = $topicService->getSortByList();

        return \View::make('dashboard.index', ['topics_data'=>$topics_data, 'setting' => $setting]);
    }


}