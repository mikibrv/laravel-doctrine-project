<?php
/**
 * User: mcsere
 * Date: 9/2/14
 * Time: 2:36 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Controllers\Admin;


use Lang;
use Session;
use Transp\Controllers\Interf\BaseController;

use Auth;
use Input;
use Redirect;
use View;

class AuthController extends BaseController
{

    private $acceptedIPS = array("127.0.0.1");


    public function index()
    {
        $userIP = $_SERVER['REMOTE_ADDR'];

        $secretToken = rand(1000, 100000);
        Session::put("token", $secretToken);
        if (in_array($userIP, $this->acceptedIPS)) {
            $view = View::make('admin.auth.login');
        } else {
            $view = View::make('admin.auth.false')->with("token", $secretToken);
        }
        return \Response::make($view);
    }

    public function indexWithToken($token)
    {
        $secretToken = Session::get("token");
        if ($token == $secretToken) {
            return View::make('admin.auth.login');
        } else {
            return View::make('admin.auth.konami');
        }
    }

    public function login()
    {
        $credentials = $this->getLoginCredentials();
        if (Auth::attempt($credentials)) {
            return Redirect::to("/admin");
        } else {
            return Redirect::route('/admin/login')
                ->with('flash_error', Lang::get("alerts.invalid.password"))
                ->withInput();
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return Redirect::to('/admin');
    }

    protected function getLoginCredentials()
    {
        return [
            "username" => Input::get("username"),
            "password" => Input::get("password")
        ];
    }

} 