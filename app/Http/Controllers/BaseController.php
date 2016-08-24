<?php
/**
 * Created by IntelliJ IDEA.
 * User: LeTung
 * Date: 西暦16/07/02
 * Time: 19:52
 */

namespace App\Http\Controllers;


use Classes\MercariAPIClient;

class BaseController extends Controller {

    /**
     * @return MercariAPIClient
     */
    static function getMercariInstant()
    {
        if (\Auth::check()) {
            return MercariAPIClient::getInstant(\Auth::user()->access_token, \Auth::user()->global_access_token);
        }

        return MercariAPIClient::getInstant();
    }
}