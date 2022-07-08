<?php

namespace App\Http\Controllers;

use App\HelperClasses\General\SettingsHandler;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $settings;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->settings = new SettingsHandler();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.admin', ['tarh_name' => $this->settings->getGeneralTarhName()]);
    }
}
