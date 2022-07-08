<?php

namespace App\Http\Controllers;

use App\HelperClasses\General\SettingsHandler;
use Illuminate\Http\Request;

class TermsController extends Controller
{

    //Global Variables
    public $settings;

    public function __construct()
    {
        $this->settings = new SettingsHandler();

    }

    public function showTerms1()
    {
        $tarh_name = $this->settings->getShopTarhName();
        return view('terms.tarh1', ['tarh_name' => $tarh_name]);
    }

    public function showTerms2()
    {
        $tarh_name = $this->settings->getSafirTarhName();
        return view('terms.tarh2', ['tarh_name' => $tarh_name]);
    }
}
