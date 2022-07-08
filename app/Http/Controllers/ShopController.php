<?php

namespace App\Http\Controllers;

use App\Distributor;
use App\HelperClasses\General\SettingsHandler;
use App\Setting;
use Auth;
use Illuminate\Http\Request;
use App\Shop;
use Carbon\Carbon;

class ShopController extends Controller
{
    private $settings;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:shop');
        $this->settings = new SettingsHandler();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tarh_name = $this->settings->getShopTarhName();
        return view('shop.shop', ['tarh_name' => $tarh_name]);
    }

    public function ShopBaseInfo()
    {
        $info = array(
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'last_name' => Auth::user()->last_name,
            'shopName' => Auth::user()->shopName,
            'tel' => Auth::user()->tel
        );
        return json_encode($info);
    }

    public function getShopProfile()
    {

        return Auth::user();
    }

    public function sendShopProfile(Request $request)
    {
        if ($request) {

            //server-side validation for received file
            $this->validate($request, [
                'resumeImage' => 'required|image|mimes:jpg,jpeg,png|max:1024'
            ]);
            //collectiong resume data
            $resume_data = array(
                'id' => json_decode($request->resume)->id->val,
                'national_id' => json_decode($request->resume)->national_id->val,
                'tel' => json_decode($request->resume)->tel->val,
                'shop_tel' => json_decode($request->resume)->shop_tel->val,
                'shop_surface' => json_decode($request->resume)->shop_surface->val,
                'living_state' => json_decode($request->resume)->living_state->val,
                'living_city' => json_decode($request->resume)->living_city->val,
                'living_area' => json_decode($request->resume)->living_area->val,
                'living_street' => json_decode($request->resume)->living_street->val,
                'shop_zip' => json_decode($request->resume)->shop_zip->val,
                'shabaID' => json_decode($request->resume)->shabaID->val,
                'credit_card' => json_decode($request->resume)->credit_card->val,

                'profile_image' => $request->resumeImage,

            );
            //saving resume data to database
            $user = Shop::where('id', '=', $resume_data['id'])->first();

            $user->shop_tel = $resume_data['shop_tel'];
            $user->national_id = $resume_data['national_id'];
            $user->living_state = $resume_data['living_state'];
            $user->living_city = $resume_data['living_city'];
            $user->living_area = $resume_data['living_area'];
            $user->living_street = $resume_data['living_street'];
            $user->shabaID = $resume_data['shabaID'];
            $user->shop_zip = $resume_data['shop_zip'];
            $user->credit_card = $resume_data['credit_card'];
            $user->shop_surface = $resume_data['shop_surface'];
            $user->sent_flag = 1;
            $user->admin_accept = 0;

            $new_name = rand() . '.' . $resume_data['profile_image']->getClientOriginalExtension();
            $resume_data['profile_image']->move(public_path("images/shops"), $new_name);
            $user->profile_image = $new_name;

            $user->save();
            return "پروفایل با موفقیت تکمیل شد! ";

        } else
            return "اطلاعات توسط سرور دریافت نشد";
    }

    public function receiveOrders(Request $request)
    {
        $transition_number = (Auth::user()->id) . rand(100, 999) . (str_replace(array("-", " ", ":"), "", Carbon::now()));
        $invoice = [];
        $shop = Shop::where('id', '=', Auth::user()->id)->first();
        $orderType = (int)json_decode($request->orderType);
        $orders = json_decode($request->orders);

        foreach ($orders as $order) {
            $invoice['distributor_id'] = $order->pivot->distributor_id;
            $invoice['barcode'] = $order->barcode;
            $invoice['pending'] = true;
            $invoice['book_name'] = $order->book_name;
            $invoice['writer'] = $order->writer;
            $invoice['publisher'] = $order->publisher;
            $invoice['fee'] = $order->fee;
            $invoice['order_count'] = $order->number;
            $invoice['order_disc_percent'] = $order->pivot->dist_disc_percent;
            $invoice['order_discount'] = intval($order->number * $order->fee * $order->pivot->dist_disc_percent / 100);
            $invoice['dist_accept'] = 0;
            $invoice['transition_number'] = $transition_number;
            $invoice['barcode'] = $order->barcode;
            $invoice['order_type'] = $orderType;

            $shop->sinvoices()->create($invoice);
        }
        return 'SUCCESS';
    }


    public function getAllDists()
    {

        $resumeList = [];
        $Resumes = Distributor::where('admin_accept', '=', 1)->get();

        foreach ($Resumes as $Resume) {
            $profile = $Resume->distProfile()->get()[0];

            $info = array(
                'id' => $Resume->id,
                'company_name' => $Resume->company_name,
                'tel' => $Resume->tel,
                'address' => $profile->living_state . "، " . $profile->living_city . "، " . $profile->living_area . "، خیابان " . $profile->living_street
            );
            array_push($resumeList, $info);
        }
        return $resumeList;
    }

}
