<?php

namespace App\Http\Controllers;


class DashboardController extends BaseController{

    public function index()
    {
        return \View::make('dashboard.index');
    }
}