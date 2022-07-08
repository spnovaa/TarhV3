<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function index()
    {
        return view('auth.reset');
    }

    public function sendCode(Request $request)
    {
        $data = json_decode($request->userData);

        $national_id = $data->nationalID;
        $phone = $data->phone;
        if (strlen($phone) != 11 || strlen($national_id) != 10) return Response::HTTP_BAD_REQUEST;
        $user = User::where(['tel' => $phone, 'national_id' => $national_id])->first();
        if (!$user) return 400;
        if ($user->total_reset_req > 50) return 400;
        $code = rand(1001, 9999);
        $user->reset_pass_code = $code;
        $user->save();
        $m = 'کابر گرامی کد تاییدیه شما ' . $code . 'است. سامانه خوشه.';
        try {
            $sender = "10005005050055";
            $message = $m;
            $receptor = array($phone);
            $result = Kavenegar::Send($sender, $receptor, $message);
        } catch (ApiException $e) {
            return $e->getCode();
        } catch (HttpException $e) {
            echo $e->getCode();
        }
        return 200;
    }

    public function resetPassword(Request $request)
    {
        $data = json_decode($request->userData);

        $national_id = $data->nationalID;
        $phone = $data->phone;
        $user_code = $data->userEnteredCode;
        $password = $data->password;
        if (strlen($phone) != 11 || strlen($national_id) != 10) return Response::HTTP_BAD_REQUEST;
        $user = User::where(['tel' => $phone, 'national_id' => $national_id, 'reset_pass_code' => $user_code])->first();
        if (!$user) return 400;
        if ($user->total_reset_req > 50) return 400;
        $user->password = Hash::make($password);
        $user->save();
        return 200;
    }

    public function confirmCode(Request $request)
    {
        $data = json_decode($request->userData);

        $national_id = $data->nationalID;
        $phone = $data->phone;
        $user_code = $data->userEnteredCode;
        if (strlen($phone) != 11 || strlen($national_id) != 10) return Response::HTTP_BAD_REQUEST;
        $user = User::where(['tel' => $phone, 'national_id' => $national_id, 'reset_pass_code' => $user_code])->first();
        if (!$user) return 400;
        if ($user->total_reset_req > 50) return 400;
        return 200;
    }
}
