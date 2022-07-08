<?php

namespace App\Http\Controllers\Admin;

use App\Distributor;
use App\HelperClasses\Admin\Excel\Safir\ActiveSafirs;
use App\HelperClasses\Admin\Excel\Safir\AllSafirsExcel;
use App\HelperClasses\Admin\Excel\Safir\NewSafirsExcel;
use App\HelperClasses\Admin\Excel\Safir\RejectedSafirsExcel;
use App\HelperClasses\Admin\Excel\Shop\ActiveShops;
use App\HelperClasses\Admin\Excel\Shop\AllShopsExcel;
use App\HelperClasses\Admin\Excel\Shop\NewShopsExcel;
use App\HelperClasses\Admin\Excel\Shop\RejectedShopsExcel;
use App\HelperClasses\Shop\DirectStatsExport;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Shop;
use App\Book;

use Kavenegar;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class ResumeController extends Controller
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

    public function pendingIndex()
    {
        return view('admin.resume.pending');
    }

    public function allIndex()
    {
        return view('admin.resume.allList');
    }

    public function getData()
    {
        $columns = [
            'id',
            'name',
            'last_name',
            'tel',
            'created_at',
            'updated_at',
        ];
        return User::where('admin_accept', '=', 0)->where('sent_flag', '=', 1)
            ->get($columns);
    }

    public function getActiveData()
    {
        return User::where('admin_accept', '=', 1)->where('active', '=', 1)->select(['id', 'name', 'last_name', 'tel'])->get();
    }


    public function getRejectedData()
    {
        return User::where('admin_accept', '=', 1)->where('active', '=', 0)->select(['id', 'name', 'last_name', 'tel'])->get();
    }

    public function getRejectedDataComplete()
    {
        return User::where('admin_accept', '=', 1)->where('active', '=', 0)->get();
    }

    public function getDataComplete()
    {
        return User::where('admin_accept', '=', 0)->where('sent_flag', '=', 1)->get();
    }

    public function getActiveDataComplete()
    {
        return User::where('admin_accept', '=', 1)->where('active', '=', 1)->get();
    }

    public function getResume(Request $request)
    {
        $resumeShow = User::where('id', '=', $request->id)->first();
        return $resumeShow;
    }

    public function getAllData()
    {
        $columns = [
            'id',
            'name',
            'last_name',
            'tel',
            'created_at',
            'updated_at',
        ];
        return User::get($columns)->toArray();
    }

    public function voteResume(Request $request)
    {
        $resume = User::where('id', '=', $request->id)->first();
        $gender = $resume->gender == 1
            ? "آقای "
            : "خانم ";
        switch ($request->result) {
            case '1':
                $resume->admin_accept = 1;
                $resume->active = 1;
                $resume->sent_flag = 1;
                $m = $gender . $resume->name . " " . $resume->last_name . "\n" . " اطلاعات شما توسط مدیریت طرح سفیر حسین ٣  بررسی و مورد تایید قرار گرفت. دسترسی شما به سامانه ی طرح فعال گردید.";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '2':
                $resume->admin_accept = 1;
                $resume->active = 0;
                $resume->sent_flag = 0;
                $m = $gender . $resume->name . " " . $resume->last_name . "\n" . "اطلاعات شما توسط مدیریت طرح سفیر حسین ٣  مورد بررسی قرار گرفته و ناقص تشخیص داده شد. لطفا نسبت به ویرایش اطلاعات خود اقدام کنید";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '3':
                $resume->admin_accept = 0;
                $resume->active = 2;
                $resume->sent_flag = 1;
                $m = $gender . $resume->name . " " . $resume->last_name . "\n" .
                    "
                    حساب کاربری شما در طرح خوشه مسدود گردید. جهت کسب اطلاعات بیشتر با پشتیبانی تماس حاصل فرمایید.
                     02166123090
                     ";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '4':
                $resume->admin_accept = 0;
                $resume->active = 1;
                $resume->sent_flag = 1;
                $m = $gender . $resume->name . " " . $resume->last_name . "\n" .
                    "
                    حساب کاربری شما در طرح خوشه موقتا تعلیق شد. جهت کسب اطلاعات بیشتر با پشتیبانی تماس بگیرید.
                    02166123090
                    ";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;

            default:
                return 'Unidentified';
                break;
        }

        $resume->save();
        return 'Vote Applied';
    }

    public function denyResume(Request $request)
    {
        $form_data = array('id' => $request->get('id_r'));
        $resume = User::where('id', '=', $form_data['id'])->first();
        $resume->admin_accept = 1;
        $resume->active = 0;
        $resume->save();
        return redirect(route('resume.pending'))->with('error', 'رزومه مردود شد');
    }

    public function editResume(Request $request)
    {
        $form_data = array('id' => $request->get('id_e'));
        $resume = User::where('id', '=', $form_data['id'])->first();
        $resume->admin_accept = 0;
        $resume->active = 0;
        $resume->sent_flag = 0;
        $resume->save();
        return redirect(route('resume.pending'))->with('error', 'رزومه جهت ارسال مجدد مرجوع گردید ');
    }


    public function getAllSafirResumesExcel()
    {
        return Excel::download(new AllSafirsExcel(), 'allSafirs.xlsx');
    }

    public function getActiveSafirResumesExcel()
    {
        return Excel::download(new ActiveSafirs(), 'activeSafirs.xlsx');
    }

    public function getRejectedSafirResumesExcel()
    {
        return Excel::download(new RejectedSafirsExcel(), 'rejectedSafirs.xlsx');
    }

    public function getNewSafirResumesExcel()
    {
        return Excel::download(new NewSafirsExcel(), 'newSafirs.xlsx');
    }

    //------------------------------------------------------------------------
    //--------------------------------Shop------------------------------------
    //------------------------------------------------------------------------

    public function getShopData()
    {
        return Shop::where('admin_accept', '=', 0)->where('sent_flag', '=', 1)->
        select('id', 'name', 'last_name', 'shop_name', 'tel')->get();
    }

    public function getActiveShopData()
    {
        return Shop::where('admin_accept', '=', 1)->where('active', '=', 1)->
        select('id', 'name', 'last_name', 'shop_name', 'tel')->get();
    }

    public function getRejectedShopData()
    {
        return Shop::where('admin_accept', '=', 0)->where('active', '=', 2)->
        select('id', 'name', 'last_name', 'shop_name', 'tel')->get();
    }

    public function getShopResume(Request $request)
    {
        $resumeShow = Shop::where('id', '=', $request->id)->first();
        return $resumeShow;
    }

    public function getAllShopData()
    {
        return Shop::get();
    }

    public function getNewShopsComplete()
    {
        return Shop::where('admin_accept', '=', 0)->where('sent_flag', '=', 1)->get();
    }

    public function getActiveShopsComplete()
    {
        return Shop::where('admin_accept', '=', 1)->where('active', '=', 1)->get();
    }

    public function getRejectedShopsComplete()
    {
        return Shop::where('admin_accept', '=', 0)->where('active', '=', 2)->get();
    }

    public function voteShopResume(Request $request)
    {
        $resume = Shop::where('id', '=', $request->id)->first();
        switch ($request->result) {
            case '1':
                $resume->admin_accept = 1;
                $resume->active = 1;
                $resume->sent_flag = 1;
                $shop = Shop::where('id', '=', $request->id)->first();
                $books = Book::get();

                foreach ($books as $book) {
//                    $book->shops()->attach($shop);
                    $book->shops()->syncWithoutDetaching($shop);
                }
                $m = "آقا/خانم " . $resume->name . " " . $resume->last_name . "\n" . "اطلاعات شما توسط مدیریت طرح مورد بررسی قرار گرفته و تایید شد.";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '2':
                $resume->admin_accept = 1;
                $resume->active = 0;
                $resume->sent_flag = 0;
                $m = "آقا/خانم " . $resume->name . " " . $resume->last_name . "\n" . "اطلاعات شما توسط مدیریت بررسی و ناقص تشخیص داده شد. لطفا مجددا نسبت به ارسال اطلاعات خود اقدام فرمایید.";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException | HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '3':
                $resume->admin_accept = 0;
                $resume->active = 2;
                $resume->sent_flag = 1;
                $m = "آقا/خانم " . $resume->name . " " . $resume->last_name . "\n" .
                    "
                    حساب کاربری شما در طرح خوشه مسدود گردید. جهت کسب اطلاعات بیشتر با پشتیبانی تماس حاصل فرمایید
                    02166123090";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '4':
                $resume->admin_accept = 0;
                $resume->active = 1;
                $resume->sent_flag = 1;
                $m = "آقا/خانم" . $resume->name . " " . $resume->last_name . "\n" .
                    "
                    حساب کاربری شما در طرح خوشه موقتا تعلیق گردید. جهت کسب اطلاعات بیشتر با پشتیبانی طرح تماس حاصل فرمایید
                    02166123090
                    ";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;

            default:
                return 'Unidentified';
                break;
        }

        $resume->save();
        return 'Vote Applied';
    }


    public function getAllShopResumesExcel()
    {
        return Excel::download(new AllShopsExcel(), 'allShops.xlsx');
    }

    public function getActiveShopResumesExcel()
    {
        return Excel::download(new ActiveShops(), 'activeShops.xlsx');
    }

    public function getRejectedShopResumesExcel()
    {
        return Excel::download(new RejectedShopsExcel(), 'rejectedShops.xlsx');
    }

    public function getNewShopResumesExcel()
    {
        return Excel::download(new NewShopsExcel(), 'newShops.xlsx');
    }

    //------------------------------------------------------------------------
    //--------------------------------Dist------------------------------------
    //------------------------------------------------------------------------

    public function getDistData()
    {
        return Distributor::where('admin_accept', 0)->where('sent_resume', 1)
            ->select('id', 'company_name', 'tel')->get();
    }

    public function getDistResume(Request $request)
    {
        $data = Distributor::where('id', '=', $request->id)->get();

        if ($data[0]->sent_resume == 1) {
            $profile = Distributor::where('id', '=', $request->id)->first()->distProfile()->
            select('national_id', 'name', 'last_name', 'profile_image', 'living_state', 'living_city',
                'living_area', 'living_street', 'shabaID', 'company_tel', 'credit_card', 'company_zip')->get();
            $all = $data->merge($profile)->all();
            $merged = array_merge($all[0]->toArray(), $all[1]->toArray());
        } else
            $merged = $data;
        return $merged;
    }


    public function voteDistResume(Request $request)
    {
        $resume = Distributor::where('id', '=', $request->id)->first();
        switch ($request->result) {
            case '1':
                $resume->admin_accept = 1;
                $resume->dist_active = 1;
                $resume->sent_resume = 1;
                $company = Distributor::where('id', '=', $request->id)->first();
                $books = Book::get();

                foreach ($books as $book) {
//                    $book->distributors()->attach($company);
                    $book->distributors()->syncWithoutDetaching($company);

                }
                $m = "شرکت " . $resume->company_name . "\n" . "اطلاعات شما توسط مدیریت طرح مورد بررسی قرار گرفته و تایید شد.";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '2':
                $resume->admin_accept = 1;
                $resume->dist_active = 0;
                $resume->sent_resume = 0;
                $m = "شرکت " . $resume->company_name . "\n" . "اطلاعات شما توسط مدیریت بررسی و ناقص تشخیص داده شد. لطفا مجددا نسبت به ارسال اطلاعات خود اقدام فرمایید.";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '3':
                $resume->admin_accept = 0;
                $resume->dist_active = 2;
                $resume->sent_resume = 1;
                $m = "شرکت " . $resume->company_name . "\n" . "حساب کاربری شما در طرح خوشه مسدود گردید. جهت کسب اطلاعات بیشتر با پشتیبانی تماس حاصل فرمایید";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;
            case '4':
                $resume->admin_accept = 0;
                $resume->dist_active = 1;
                $resume->sent_resume = 1;
                $m = "شرکت " . $resume->company_name . "\n" . "حساب کاربری شما در طرح خوشه موقتا تعلیق گردید. جهت کسب اطلاعات بیشتر با پشتیبانی طرح تماس حاصل فرمایید";
                try {
                    $sender = "";
                    $message = $m;
                    $receptor = array($resume->tel);
                    $result = Kavenegar::Send($sender, $receptor, $message);
                } catch (ApiException $e) {
                    echo $e->errorMessage();
                } catch (HttpException $e) {
                    echo $e->errorMessage();
                }
                break;

            default:
                return 'Unidentified';
                break;
        }

        $resume->save();
        return 'Vote Applied';
    }

}
