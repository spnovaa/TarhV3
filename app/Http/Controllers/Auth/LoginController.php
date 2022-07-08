<?php

namespace App\Http\Controllers\Auth;

use App\HelperClasses\General\SettingsHandler;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    private $settings;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->settings = new SettingsHandler();
    }

    public function showLoginForm()
    {
        if (!$this->settings->getSafirActive()) {
            return Redirect::to('http://khooshe.org');
        } else {
            $tarh_name = $this->settings->getSafirTarhName();
            return view('auth.login', ['tarh_name' => $tarh_name]);
        }
    }

    /**
     * Get the login tel to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'tel';
    }

}
