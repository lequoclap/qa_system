<?php

namespace App\Http\Controllers;


use App\Models\Topic;

class DashboardController extends BaseController{

    public function index()
    {
        $topics = Topic::join('users', 'users.id', '=', 'user_id')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->select('topics.*', 'users.name as user_name', 'categories.name as category_name')
            ->get();
        //VOTE
        return \View::make('dashboard.index', ['topics'=>$topics]);
    }
}