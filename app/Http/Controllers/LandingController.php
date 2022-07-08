<?php

namespace App\Http\Controllers;

use App\HelperClasses\General\SettingsHandler;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    private $settings;

    /**
     * LandingController constructor.
     * @param $settings
     */
    public function __construct()
    {
        $this->settings = new SettingsHandler();
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (Auth::check() && Auth::guard('web'))
            return view('safir.home', ['tarh_name' => $this->settings->getSafirTarhName()]);
        else
            return view('home', ['tarh_name' => $this->settings->getGeneralTarhName()]);
    }
}
