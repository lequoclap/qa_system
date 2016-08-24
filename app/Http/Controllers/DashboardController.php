<?php
/**
 * Created by IntelliJ IDEA.
 * User: LeTung
 * Date: 西暦16/07/09
 * Time: 11:57
 */

namespace App\Http\Controllers;


class DashboardController extends BaseController{

    public function index()
    {
        $client = BaseController::getMercariInstant();
        $response = $client->get('/notifications/get_count');
        return \View::make('dashboard.index');
    }
}