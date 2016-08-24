<?php
/**
 * Created by IntelliJ IDEA.
 * User: LeTung
 * Date: 西暦16/07/06
 * Time: 19:54
 */

namespace App\Http\Controllers;


class NewsController extends BaseController{

    public function listPage()
    {
        $client = BaseController::getMercariInstant();
        $news = $client->getNews();

        return \View::make('news.list', ['news' => isset($news['data']) ? $news['data'] : []]);
    }

    public function getNewsDetail($id)
    {
        $client = BaseController::getMercariInstant();
        $news = $client->getNews($id);

        return \Response::json($news['data'], 200);
    }
}