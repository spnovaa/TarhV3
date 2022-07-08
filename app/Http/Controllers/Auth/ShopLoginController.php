<?php

namespace App\Http\Controllers\Auth;

use App\HelperClasses\General\SettingsHandler;
use Illuminate\Http\Request;
use App\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShopLoginController extends Controller
{
    //Global Varibles
    public $settings;

    public $shop_active_setting;

    public function __construct()
    {
        $this->middleware('guest:shop');
        $this->settings = new SettingsHandler();
        $this->shop_active_setting = $this->settings->getShopActive();
    }

    public function showLoginForm()
    {
        $tarh_name = $this->settings->getShopTarhName();
        return view('auth.shop.shop-login', ['tarh_name' => $tarh_name]);
    }

    public function login(Request $request)
    {

        //validate the login request
        $this->validate($request, [
            'tel' => 'required',
            'password' => 'required|min:7'
        ]);
        if ($this->shop_active_setting) {
            //attempt to login
            if (Auth::guard('shop')->attempt(
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
        } else {
            return 402;
        }

    }
}
