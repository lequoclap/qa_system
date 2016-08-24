<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRelation;
use Classes\Constants;
use Illuminate\Http\Request;


class UserController extends BaseController{

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function loginPage()
    {
        return \View::make('user.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $user = $this->getUser($request);
        if(!$user){
            $request->session()->flash(Constants::MSG_TYPE_ERROR, 'Email or password is incorrect!');
            return \Redirect::to('/login');
        }
        \Auth::login($user);

        return \Redirect::to('/');
    }

    /**
     * @param Request $request
     * @return User
     */
    private function getUser(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where(['email' => $email, 'password' => $password])->first();

        return $user;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        \Auth::logout();

        return \Redirect::to('/login');
    }


    public function registerPage(){
        return \View::make('user.register');
    }

    public function register(Request $request){

        $email = $request->input('email');
        $re_password = $request->input('password');
        $re_password = $request->input('re-password');
        $name = $request->input('name');

        g


        return \Redirect::to('/login');
    }
}