<?php

namespace App\Http\Controllers;

use App\HelperClasses\General\SettingsHandler;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Setting;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    //Global Varibles
    public $settings;

    public $safir_active_setting;
    protected $resume_data;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->settings = new SettingsHandler();
        $this->safir_active_setting = $this->settings->getSafirActive();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            $tarh_name = $this->settings->getSafirTarhName();
            return view('safir.home', ['tarh_name' => $tarh_name]);
    }

    public function BaseInfo()
    {
        $info = array(
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'last_name' => Auth::user()->last_name,
            'email' => Auth::user()->email,
            'tel' => Auth::user()->tel
        );
        return json_encode($info);
    }

    public function getProfile()
    {
        return Auth::user();
    }

    public function sendProfile(Request $request)
    {
        if ($request) {

            //server-side validation for received file
            $this->validate($request, [
                'resumeImage' => 'image|mimes:jpg,jpeg,png,bmp,pjpeg|max:1024|nullable'
            ]);
            //collectiong resume data
            $resume_data = array(
                'fathers_name' => json_decode($request->resume)->fathers_name->val,
                'email' => json_decode($request->resume)->email->val,
                'gender' => json_decode($request->resume)->gender->val,
                'national_id' => json_decode($request->resume)->national_id->val,
                'tel' => json_decode($request->resume)->tel->val,
                'born_date' => json_decode($request->resume)->born_date->val,
                'living_state' => json_decode($request->resume)->living_state->val,
                'living_city' => json_decode($request->resume)->living_city->val,
                'living_area' => json_decode($request->resume)->living_area->val,
                'living_street' => json_decode($request->resume)->living_street->val,
                'living_alley' => json_decode($request->resume)->living_alley->val,
                'living_plaque' => json_decode($request->resume)->living_plaque->val,
                'living_zip' => json_decode($request->resume)->living_zip->val,
                'educated_at' => json_decode($request->resume)->educated_at->val,
                'education_grade' => json_decode($request->resume)->education_grade->val,
                'education_city' => json_decode($request->resume)->education_city->val,
                'education_branch' => json_decode($request->resume)->education_branch->val,
                'selling_background' => json_decode($request->resume)->selling_background->val,
                'book_background' => json_decode($request->resume)->book_background->val,
                'last_read_3b' => json_decode($request->resume)->last_read_3b->val,
                'suggestion' => json_decode($request->resume)->suggestion->val,
                'moarref' => json_decode($request->resume)->moarref->val,
                'payamresan' => json_decode($request->resume)->payamresan->val,
                'payamresan_phone' => json_decode($request->resume)->payamresan_phone->val,
                'instagram' => json_decode($request->resume)->instagram->val,
                'heyat_name' => json_decode($request->resume)->heyat_name->val,
                'manager_name' => json_decode($request->resume)->manager_name->val,
                'manager_tel' => json_decode($request->resume)->manager_tel->val,
                'heyat_adress' => json_decode($request->resume)->heyat_adress->val,
                'shabaID' => json_decode($request->resume)->shabaID->val,

                'profile_image' => $request->resumeImage,

            );
            //saving resume data to database
            if ($this->custom_check_national_code($resume_data['national_id'])) {
                $user = User::where('email', '=', $resume_data['email'])->first();

                $user->fathers_name = $resume_data['fathers_name'];
                $user->gender = $resume_data['gender'];
                $user->national_id = $resume_data['national_id'];
                $user->tel = $resume_data['tel'];
                $user->born_date = $resume_data['born_date'];
                $user->living_state = $resume_data['living_state'];
                $user->living_city = $resume_data['living_city'];
                $user->living_area = $resume_data['living_area'];
                $user->living_street = $resume_data['living_street'];
                $user->living_alley = $resume_data['living_alley'];
                $user->living_plaque = $resume_data['living_plaque'];
                $user->living_zip = $resume_data['living_zip'];
                $user->educated_at = $resume_data['educated_at'];
                $user->education_grade = $resume_data['education_grade'];
                $user->education_city = $resume_data['education_city'];
                $user->education_branch = $resume_data['education_branch'];
                $user->selling_background = $resume_data['selling_background'];
                $user->book_background = $resume_data['book_background'];
                $user->last_read_3b = $resume_data['last_read_3b'];
                $user->suggestion = $resume_data['suggestion'];
                $user->moarref = $resume_data['moarref'];
                $user->payamresan_phone = $resume_data['payamresan_phone'];
                $user->payamresan = $resume_data['payamresan'];
                $user->instagram = $resume_data['instagram'];
                $user->heyat_name = $resume_data['heyat_name'];
                $user->manager_name = $resume_data['manager_name'];
                $user->manager_tel = $resume_data['manager_tel'];
                $user->heyat_adress = $resume_data['heyat_adress'];
                $user->shabaID = $resume_data['shabaID'];
                $user->sent_flag = 1;

                if($resume_data['profile_image']) {
                    $new_name = rand() . '.' . $resume_data['profile_image']->getClientOriginalExtension();
                    $resume_data['profile_image']->move(public_path("images"), $new_name);
                    $user->profile_image = $new_name;
                }
                $user->save();
                return "پروفایل با موفقیت تکمیل شد! ";


            } else {
                return "WRNGCD";
            }
        } else
            return "اطلاعات توسط سرور دریافت نشد";
    }

    function custom_check_national_code($code)
    {
        if (!preg_match('/^[0-9]{10}$/', $code))
            return false;
        for ($i = 0; $i < 10; $i++)
            if (preg_match('/^' . $i . '{10}$/', $code))
                return false;
        for ($i = 0, $sum = 0; $i < 9; $i++)
            $sum += ((10 - $i) * intval(substr($code, $i, 1)));
        $ret = $sum % 11;
        $parity = intval(substr($code, 9, 1));
        if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
            return true;
        return false;
    }
}
