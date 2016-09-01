<?php

namespace App\Http\Controllers;

use Classes\Services\TopicService;

use Illuminate\Support\Facades\Input;

class DashboardController extends BaseController{



    public function index()
    {
        $extra = Array();
        $extra['sort_by'] = Input::get('sort-by');
        $extra['order_type'] = Input::get('order-type');
        $extra['search_term'] = Input::get('search-term');
        $extra['tags'] =Input::get('tags');

        $topicService = new TopicService();
        $topics_data  = $topicService->getTopicList($extra);


        $setting = Array();
        $setting['order_type'] = $extra['order_type'];

        return \View::make('dashboard.index', ['topics_data'=>$topics_data, 'setting' => $setting]);
    }


}