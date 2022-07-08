<?php

namespace App\Http\Controllers\Auth;

use App\HelperClasses\General\SettingsHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    private $settings;

    public function __construct()
    {
        $this->middleware('guest:admin');
        $this->settings = new SettingsHandler();
    }

    public function showLoginForm()
    {
        return view('auth.admin.admin-login', ['tarh_name' => $this->settings->getGeneralTarhName()]);
    }

    public function login(Request $request)
    {

        //validate the login request
        $this->validate($request, [
            'tel' => 'required',
            'password' => 'required|min:7'
        ]);
        //attempt to login
        if (Auth::guard('admin')->attempt(
            [
                'tel' => $request->tel,
                'password' => $request->password
            ],
            $request->remember)) {
            //if successful then redirect to their intended location
            return 200;
        }
        //if not succeeded then redirect to the lofin form with datafill
        return 400;
    }
}
