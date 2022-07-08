<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Setting;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;

class DistributorLoginController extends Controller
{
    //Global Varibles
    public $setting;

    public $dist_active_setting;

    public function __construct()
    {
        $this->middleware('guest:distributor');
        $settings = Setting::first();
        $this->dist_active_setting = $settings->dist_active;
    }

    public function showLoginForm()
    {
        return view('auth.distributor.distributor-login');
    }

    public function login(Request $request)
    {

        //validate the login request
        $this->validate($request, [
            'tel' => 'required',
            'password' => 'required|min:7'
        ]);
        if ($this->dist_active_setting) {
            //attempt to login
            if (Auth::guard('distributor')->attempt(
                [
                    'tel' => $request->tel,
                    'password' => $request->password
                ],
                $request->remember)) {
                //if successful then redirect to their intended location
                return redirect()->intended(route('distributor.dashboard'));
            }
            //if not succeeded then redirect to the lofin form with datafill
            return redirect()->back()->withInput($request->only('tel', 'remember'));
        }
    }
}
