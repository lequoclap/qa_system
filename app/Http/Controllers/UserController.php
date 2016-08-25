<?php


namespace App\Http\Controllers;

use App\Models\User;
use Classes\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


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
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $request->session()->flash(Constants::MSG_TYPE_ERROR, 'Invalid email address!');
            return Redirect::to('login')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $userdata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password')
            );

            if (\Auth::attempt($userdata)) {
                return Redirect::to('/');

            } else {
                $request->session()->flash(Constants::MSG_TYPE_ERROR, 'Email or password is incorrect!');
                return Redirect::to('/login');

            }

        }
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
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required|alphaNum|min:3|confirmed',
            'name' => 'required|alphaNum'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $request->session()->flash(Constants::MSG_TYPE_ERROR, $validator->errors());
            return Redirect::to('/register')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $input_data = $request->input();
            User::createOrUpdate($input_data);
            return \Redirect::to('/login');
        }
    }

}