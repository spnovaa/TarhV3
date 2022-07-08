<?php

namespace App\Http\Controllers\Admin;

use View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;


class SettingsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getSettings()
    {
        $settings = Setting::first();
        if (!$settings) {
            Setting::create([
                "tarh_name" => "",
            ]);
        }
        $settings = Setting::first();
        return $settings;

    }

    public function saveSettings(Request $request)
    {
        $settings = Setting::first();

        $settings->tarh_name = $request->tarh_name;
        $settings->safir_tarh_name = $request->safir_tarh_name;
        $settings->shop_tarh_name = $request->shop_tarh_name;
        $settings->dist_tarh_name = $request->dist_tarh_name;
        $settings->safir_percentage = $request->safir_percentage;
        $settings->shop_percentage = $request->shop_percentage;
        $settings->dist_percentage = $request->dist_percentage;
        $settings->customer_percentage = $request->customer_percentage;
        $settings->customer_percentage_limit = $request->customer_percentage_limit;
        $settings->safir_active = $request->safir_active;
        $settings->shop_active = $request->shop_active;
        $settings->dist_active = $request->dist_active;
        $settings->customer_buy_count_limit = $request->customer_buy_count_limit;
        $settings->customer_buy_count_limit_per_book = $request->customer_buy_count_limit_per_book;
        $settings->can_shop_add_book = $request->can_shop_add_book;

        $settings->save();
        return "SUCCESS";
    }

}
