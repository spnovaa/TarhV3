<?php

namespace App\Http\Controllers;

use App\DistProfile;
use App\Distributor;
use App\HelperClasses\General\SettingsHandler;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Ramsey\Collection\Collection;

class DistributorController extends Controller
{
    private $settings;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:distributor');
        $this->settings = new SettingsHandler();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tarh_name = $this->settings->getDistributorTarhName();
        return view('distributor.distributor', ['tarh_name' => $tarh_name]);
    }

    public function getDistributorProfile()
    {
        $user = Auth::user();

        if ($user->sent_resume == 1) {
            $profile = $user->distProfile()->where('distributor_id', $user->id)->first();
            return $profile->toArray() + $user->toArray();
        } else {
            return $user;
        }
    }

    public function SendDistributorProfile(Request $request)
    {
        if ($request) {
            //server-side validation for received file
            $this->validate($request, [
                'resumeImage' => 'required|image|mimes:jpg,jpeg,png|max:1024'
            ]);
            //collecting resume data
            $resume_data = array(
                'id' => json_decode($request->resume)->id->val,
                'national_id' => json_decode($request->resume)->national_id->val,
                'name' => json_decode($request->resume)->name->val,
                'last_name' => json_decode($request->resume)->last_name->val,
                'tel' => json_decode($request->resume)->tel->val,
                'living_state' => json_decode($request->resume)->living_state->val,
                'living_city' => json_decode($request->resume)->living_city->val,
                'living_area' => json_decode($request->resume)->living_area->val,
                'living_street' => json_decode($request->resume)->living_street->val,
                'shabaID' => json_decode($request->resume)->shabaID->val,
                'credit_card' => json_decode($request->resume)->credit_card->val,
                'company_zip' => json_decode($request->resume)->company_zip->val,
                'company_tel' => json_decode($request->resume)->company_tel->val,

                'profile_image' => $request->resumeImage,

            );
            //saving resume data to database
            $user = Distributor::where('id', '=', $resume_data['id'])->first();
            $new_name = rand() . '.' . $resume_data['profile_image']->getClientOriginalExtension();
            $resume_data['profile_image']->move(public_path("images/distributors"), $new_name);
            $user_profile = $user->distProfile()->where('distributor_id', $resume_data['id'])->first();

            if ($user_profile == null)
                $user_profile = new DistProfile();

            $user_profile->profile_image = $new_name;
            $user_profile->national_id = $resume_data['national_id'];
            $user_profile->name = $resume_data['name'];
            $user_profile->last_name = $resume_data['last_name'];
            $user_profile->living_state = $resume_data['living_state'];
            $user_profile->living_city = $resume_data['living_city'];
            $user_profile->living_area = $resume_data['living_area'];
            $user_profile->living_street = $resume_data['living_street'];
            $user_profile->shabaID = $resume_data['shabaID'];
            $user_profile->distributor_id = $resume_data['id'];
            $user_profile->credit_card = $resume_data['credit_card'];
            $user_profile->company_zip = $resume_data['company_zip'];
            $user_profile->company_tel = $resume_data['company_tel'];

            $user->sent_resume = 1;
            $user->admin_accept = 0;

            $user_profile->save();
            $user->save();
            return "پروفایل با موفقیت تکمیل شد! ";

        } else
            return "اطلاعات توسط سرور دریافت نشد";
    }
}
