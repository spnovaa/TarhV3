<?php

namespace App\Http\Controllers\Safir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\Shop;
use App\User;
use App\Customer;
use App\Safinvoice;
use App\Custinvoice;
use Auth;
use Carbon\Carbon;
use App\Setting;

use Kavenegar;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class OrderController extends Controller
{
    //Global Varibles
    public $setting;
    public $tarh_name_setting;
    public $safir_percentage_setting;
    public $shop_percentage_setting;
    public $dist_percentage_setting;
    public $customer_percentage_setting;
    public $customer_percentage_limit_setting;
    public $safir_active_setting;
    public $shop_active_setting;
    public $dist_active_setting;
    public $customer_buy_count_limit;

    //

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $settings = Setting::first();
        $this->tarh_name_setting = $settings->tarh_name;
        $this->safir_percentage_setting = $settings->safir_percentage * 0.01;
        $this->shop_percentage_setting = $settings->shop_percentage * 0.01;
        $this->dist_percentage_setting = $settings->dist_percentage * 0.01;
        $this->customer_percentage_setting = $settings->customer_percentage * 0.01;
        $this->customer_percentage_limit_setting = $settings->customer_percentage_limit;
        $this->safir_active_setting = $settings->safir_active;
        $this->shop_active_setting = $settings->shop_active;
        $this->dist_active_setting = $settings->dist_active;
        $this->customer_buy_count_limit = $settings->customer_buy_count_limit;

    }

    public function getAllShops()
    {
        $resumeList = [];
        $Resumes = Shop::where('admin_accept', '=', 1)->get();
        foreach ($Resumes as $Resume) {
            $info = array(
                'id' => $Resume->id,
                'shop_name' => $Resume->shop_name,
                'tel' => $Resume->tel,
                'address' => $Resume->living_state . "، " . $Resume->living_city . "، " . $Resume->living_area . "، خیابان " . $Resume->living_street
            );
            array_push($resumeList, $info);
        }
        return $resumeList;
    }

    public function getAllBooks(Request $request)
    {
        $response = [];
        $shop_id = $request->shop_id;
        $shop = Shop::find($shop_id);
        $bookList = $shop->books->where('deleted', '=', false);
        array_push($response, $bookList);
        $shop_name = $shop->shop_name;
        array_push($response, $shop_name);
        return $response;

    }

    public function receiveOrder(Request $request)
    {
        $transition_number = (Auth::user()->id) . rand(100, 999) . (str_replace(array("-", " ", ":"), "", Carbon::now()));
        $invoice = [];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $orderType = (int)json_decode($request->orderType);
        $orders = json_decode($request->orders);

        foreach ($orders as $order) {
            $invoice['shop_id'] = $order->pivot->shop_id;
            $invoice['barcode'] = $order->barcode;
            $invoice['pending'] = true;
            $invoice['book_name'] = $order->book_name;
            $invoice['writer'] = $order->writer;
            $invoice['publisher'] = $order->publisher;
            $invoice['fee'] = $order->fee;
            $invoice['order_count'] = $order->number;
            $invoice['inv_accept'] = 0;
            $invoice['tarh_accept'] = 0;
            $invoice['accept_sum'] = 0;
            $invoice['transition_number'] = $transition_number;
            $invoice['order_type'] = $orderType;
            $user->safinvoices()->create($invoice);
        }
        return 'SUCCESS';
    }

    public function getAllSafirShopOrders()
    {
        $shop = Shop::class;
        $ordersList = [];
        $invoices = Safinvoice::where('user_id', '=', Auth::id())->get()->unique('transition_number');
        $lists = $invoices->map(function ($invoices) {
            return collect($invoices->toArray())
                ->only(['id', 'shop_id', 'transition_number', 'order_type', 'pending', 'porterage', 'porterage_type'])
                ->all();
        });
        foreach ($lists as $list) {

            $order = array(
                'id' => $list['id'],
                'shop_name' => Shop::find($list['shop_id'])->shop_name,
                'transition_number' => $list['transition_number'],
                'porterage' => $list['porterage'],
                'porterage_type' => $list['porterage_type'],
                'order_type' => $list['order_type'] == 1 ?
                    'خرید' :
                    'مرجوعی',

                'tel' => Shop::find($list['shop_id'])->tel,

                'status' => $list['pending'] == 1 ?
                    'درحال بررسی' :
                    'بررسی شده'
            );

            array_push($ordersList, $order);
        }
        return $ordersList;

    }


    public function getAllSafirCustomerOrders()
    {
        $customer = Customer::class;
        $ordersList = [];
        $invoices = Custinvoice::where('user_id', '=', Auth::id())->get()->unique('transition_number');
        $lists = $invoices->map(function ($invoices) {
            return collect($invoices->toArray())
                ->only(['id', 'customer_id', 'transition_number',])
                ->all();
        });
        foreach ($lists as $list) {

            $order = array(
                'id' => $list['id'],
                'customer_name' => Customer::find($list['customer_id'])->name . " " . Customer::find($list['customer_id'])->last_name,
                'transition_number' => $list['transition_number'],
                'tel' => Customer::find($list['customer_id'])->tel,
            );

            array_push($ordersList, $order);
        }
        return $ordersList;

    }


    public function sendOrder(Request $request)
    {
        $order = Safinvoice::where('transition_number', '=', $request->transition_number)->get();

        return $order;
    }

    public function sendCustomerOrder(Request $request)
    {
        $order = Custinvoice::where('transition_number', '=', $request->transition_number)->get();

        return $order;
    }


    public function confirmOrder(Request $request)
    {
        if ($request) {

            $user = User::find(Auth::id());
            $safirInvoiceItems = Safinvoice::where('transition_number', '=', $request->transition_number)->get();
            $user_books = $user->books;

            foreach ($safirInvoiceItems as $safirInvoiceItem) {
                $book_is_registered = false;
                $book = Book::where('barcode', '=', $safirInvoiceItem->barcode)->first();

                foreach ($user_books as $user_book) {
                    if ($user_book->barcode == $book->barcode)
                        $book_is_registered = true;
                }
                $book_id = $book->id;
                if (!$book_is_registered) {
//                    $user->books()->attach($book);
                    $user->books()->syncWithoutDetaching($book);

                }
            }
            $books = [];
            foreach ($safirInvoiceItems as $safirInvoiceItem) {

                $book = Book::where('barcode', '=', $safirInvoiceItem->barcode)->first();
                $invoiceKey = $user->books()->where('barcode', '=', $book->barcode)->first()->pivot;

                if ($safirInvoiceItem->order_type == 1) {
                    $inventory = $invoiceKey->safir_inv + $safirInvoiceItem->accept_sum;

                } elseif ($safirInvoiceItem->order_type == 2) {

                    $inventory = $invoiceKey->safir_inv - $safirInvoiceItem->accept_sum;
                }

                $invoiceKey->safir_inv = $inventory;
                $invoiceKey->save();
                $safirInvoiceItem->safir_confirm = 1;

                $safirInvoiceItem->save();
            }
            return 'SUCCESS';
        } else
            return 'FAILURE';
    }

    public function getInventory()
    {
        $user = User::find(Auth::id());
        $bookList = $user->books->where('deleted', '=', false);
        return $bookList;

    }

    public function inquire(Request $request)
    {
        $national_id = $request->national_id;
        if ($this->custom_check_national_code($national_id)) {
            $customer = Customer::where('national_id', '=', $national_id)->first();
            if ($customer) {
                return array(
                    "info" => array(
                        "is_registered" => true,
                        "name" => $customer->name,
                        "last_name" => $customer->last_name,
                        "national_id" => $customer->national_id,
                        "tel" => $customer->tel,
                        "used" => $customer->used,
                        "bought_count" => $customer->bought_count,

                        "limit_setting" => $this->customer_percentage_limit_setting,
                        "percentage_setting" => $this->customer_percentage_setting,
                        "customer_buy_count_limit" => $this->customer_buy_count_limit,

                    ));
            } else {
                return array(
                    "info" => array(
                        "is_registered" => false,
                        "name" => "",
                        "last_name" => "",
                        "national_id" => "",
                        "tel" => "",
                        "used" => "0",
                        "bought_count" => $customer->bought_count,

                        "limit_setting" => $this->customer_percentage_limit_setting,
                        "percentage_setting" => $this->customer_percentage_setting,
                        "customer_buy_count_limit" => $this->customer_buy_count_limit,

                    ));
            }
        } else {
            return "INCORRECT";
        }
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

    public function receiveInvoice(Request $request)
    {
        $user = User::find(Auth::id());
        $orders = $request->orders;
        $info = $request->customer["info"];
        $national_id = $info["national_id"];

        //Retriving Customer For Additional Security Check. So That Client Could Not Create Duplicated Customer
        $customer = Customer::where('national_id', '=', $national_id)->first();

        //Creating New Customer If Needed
        if (!$info["is_registered"] && $this->custom_check_national_code($info["national_id"]) && !$customer) {

            Customer::create([
                'name' => $info["name"],
                'last_name' => $info["last_name"],
                'tel' => $info["tel"],
                'national_id' => $info["national_id"],
            ]);
            $customer = Customer::where('national_id', '=', $national_id)->first();

//            $user->customers()->attach($customer);
            $user->customers()->syncWithoutDetaching($customer);

            try {
                $sender = "";
                $message = " خانم/آقای " .
                    $info["name"] . " " . $info["last_name"] .
                    " ثبت نام شما در طرح " . $this->tarh_name_setting . " با موفقیت انجام شد!";
                $receptor = array($info["tel"]);
                $result = Kavenegar::Send($sender, $receptor, $message);
            } catch (ApiException | HttpException $e) {
            }

        } elseif (!$this->custom_check_national_code($info["national_id"])) {
            return "کد ملی وارد شده صحیح نیست";
        }

        $transition_number = (Auth::user()->id) . rand(100, 999) . (str_replace(array("-", " ", ":"), "", Carbon::now()));
        $invoice = [];
        $customer_id = Customer::where('national_id', '=', $national_id)->first()->id;
        $used = $customer->used;
        $overal = 0;
        $invoiceMessage = "";
        foreach ($orders as $order) {
            $book = Book::where('barcode', '=', $order["barcode"])->first();

            $overal = $overal + ($book->fee) * ($order["number"]);

            $invoice['customer_id'] = $customer_id;
            $invoice['barcode'] = $order["barcode"];
            $invoice['book_name'] = $order["book_name"];
            $invoice['writer'] = $order["writer"];
            $invoice['publisher'] = $order["publisher"];
            $invoice['fee'] = $order["fee"];
            $invoice['order_count'] = $order["number"];
            $invoice['transition_number'] = $transition_number;

            $invoiceMessage = $invoiceMessage . $invoice['book_name'] . " " . $invoice['order_count'] . " جلد" . "\n";
            $user->custinvoices()->create($invoice);

            $book = $user->books->where('barcode', '=', $order["barcode"])->first()->pivot;
            $book->safir_inv -= $order["number"];
            $book->safir_sold += $order["number"];
            $book->save();
        }

        $discount_raw = $overal * $this->customer_percentage_setting + $used;
        if ($discount_raw >= $this->customer_percentage_limit_setting) {
            $order_discount = $this->customer_percentage_limit_setting - $used;
            $used = $this->customer_percentage_limit_setting;
        } else {
            $order_discount = $discount_raw - $used;
            $used = $discount_raw;
        }
        $invoiceMessage = "خرید شما با مشخصات " . $invoiceMessage . "به مجموع کل " . $overal . " و تخفیف اعمال شده ی " . $order_discount .
            " با شماره پیگیری " . $transition_number . " ثبت گردید\n" .
            "درصورت مشاهده ی هرگونه مغایرت با پشتیبانی سامانه به شماره 02166123090 تماس بگیرید.";
        try {
            $sender = "";
            $message = $invoiceMessage;
            $receptor = array($customer->tel);
            $result = Kavenegar::Send($sender, $receptor, $message);

        } catch (ApiException | HttpException $e) {
//            echo $e->errorMessage();
        }

        $invoice_flag = $user->custinvoices->where('transition_number', '=', $transition_number)->first();
        $invoice_flag->order_discount = $order_discount;
        $customer->used = $used;
        $customer->bought_count = $info['bought_count'];
        $invoice_flag->save();
        $customer->save();
        return "SUCCESS";
    }
}
