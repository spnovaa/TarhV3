<?php

namespace App\Http\Controllers\Auth;

use App\DistProfile;
use App\Distributor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Shop;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class AjaxController extends Controller
{
    public function Register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'last_name' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:50'],
            'tel' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:200'],
            'email' => ['required', 'string', 'unique:users']
        ]);
        if ($validator->fails())
            return "ایمیل یا تلفن همراه وارد شده تکراریست!";
        else {
            $data = $request->toArray();
            User::create([
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'tel' => $data['tel'],
                'password' => Hash::make($data['password']),
            ]);
            return "ثبت نام با موفقیت انجام شد. از همین صفحه وارد شوید";
        }

    }

    public function shopRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'last_name' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:50'],
            'tel' => ['required', 'string', 'unique:shops'],
            'shopName' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:200'],
        ]);
        if ($validator->fails())
            return "شما قبلا ثبت نام کرده اید. میتوانید وارد شوید!";
        else {
            $data = $request->toArray();
            Shop::create([
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'shop_name' => $data['shopName'],
                'tel' => $data['tel'],
                'password' => Hash::make($data['password']),
            ]);
            return "ثبت نام با موفقیت انجام شد. از همین صفحه وارد شوید";
        }

    }

    public function distributorRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companyName' => ['required', 'string', 'max:150'],
            'tel' => ['required', 'string', 'unique:distributors'],
            'password' => ['required', 'string', 'min:8', 'max:200'],
        ]);
        if ($validator->fails())
            return "امکان ثبت نام با این اطلاعات وجود ندارد!";
        else {
            $data = $request->toArray();

            Distributor::create([
                'company_name' => $data['companyName'],

                'tel' => $data['tel'],
                'password' => Hash::make($data['password']),
            ]);
            return "ثبت نام با موفقیت انجام شد. از همین صفحه وارد شوید";
        }

    }

    public function checkUserType()
    {
        if (Auth::guard('admin')->check()) {
            return "Admin";
        } elseif (Auth::guard('shop')->check()) {
            return "Shop";
        } elseif (Auth::guard('distributor')->check()) {
            return "Dist";
        } else {
            return "Safir";
        }
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' => $data['mobile_no'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
