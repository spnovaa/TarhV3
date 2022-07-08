<?php

namespace App\Http\Controllers\Shop;

use App\HelperClasses\General\SettingsHandler;
use App\Stat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Book;
use App\Shop;
use App\Customer;
use App\Sinvoice;
use App\Safinvoice;
use App\Custinvoice;
use Carbon\Carbon;
use \stdClass;
use Kavenegar;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class OrderController extends Controller
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

    public function getAllOrders()
    {
        $shop = Shop::class;
        $ordersList = [];
        $invoices = Sinvoice::where('shop_id', '=', Auth::id())->get()->unique('transition_number');
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

        $shop = Shop::find(Auth::id());
        $action =
            " فروشگاه " .
            $shop->shop_name
            .
            " لیست تمامی سفارشات خود را مشاهده کرد";
        $stat = ["action" => $action];
        $shop->stats()->create($stat);

        return $ordersList;
    }

    public function getShopAddNewBookSettings()
    {
        return $this->settings->getCanShopAddNewBook();
    }

    public function getAllSafirOrders()
    {
        $user = User::class;
        $ordersList = [];
        $invoices = Safinvoice::where('shop_id', '=', Auth::id())->get()->unique('transition_number');
        $lists = $invoices->map(function ($invoices) {
            return collect($invoices->toArray())
                ->only(['id', 'user_id', 'transition_number', 'order_type', 'pending', 'porterage', 'porterage_type'])
                ->all();
        });
        foreach ($lists as $list) {

            $order = array(
                'id' => $list['id'],
                'safir_name' => User::find($list['user_id'])->name . " " . User::find($list['user_id'])->last_name,
                'transition_number' => $list['transition_number'],
                'porterage' => $list['porterage'],
                'porterage_type' => $list['porterage_type'],
                'order_type' => $list['order_type'] == 1 ?
                    'خرید' :
                    'مرجوعی',

                'tel' => User::find($list['user_id'])->tel,

                'status' => $list['pending'] == 1 ?
                    'درحال بررسی' :
                    'بررسی شده'
            );

            array_push($ordersList, $order);
        }
        return $ordersList;

    }

    public function getOrder(Request $request)
    {
        $order = Sinvoice::where('transition_number', '=', $request->transition_number)->get();

        return $order;
    }

    public function getSafirOrder(Request $request)
    {
        $order = Safinvoice::where('transition_number', '=', $request->transition_number)->get();
        foreach ($order as $item) {
            $item->shop_seen = 1;
            $item->save();
        }
        return $order;
    }

    public function confirmOrder(Request $request)
    {
        if ($request) {

            $shop = Shop::find(Auth::id());
            $shopInvoiceItems = Sinvoice::where('transition_number', '=', $request->transition_number)->get();

            foreach ($shopInvoiceItems as $shopInvoiceItem) {

                $book_id = Book::where('barcode', '=', $shopInvoiceItem->barcode)->first()->id;

                $invoiceKey = $shop->books->where('id', '=', $book_id)->first()->pivot;

                if ($shopInvoiceItem->order_type == 1) {
                    $inventory = $invoiceKey->shop_inv + $shopInvoiceItem->dist_accept;

                } elseif ($shopInvoiceItem->order_type == 2) {

                    $inventory = $invoiceKey->shop_inv - $shopInvoiceItem->dist_accept;
                }

                $invoiceKey->shop_inv = $inventory;
                $invoiceKey->save();
                $shopInvoiceItem->shop_confirm = 1;

                $shopInvoiceItem->save();
            }

            $shop = Shop::find(Auth::id());
            $action =
                " فروشگاه " .
                $shop->shop_name
                .
                " سفارش با کد "
                .
                $request->transition_number
                .
                " را تایید کرد";
            $stat = ["action" => $action];
            $shop->stats()->create($stat);

            return 'SUCCESS';
        } else {

            $shop = Shop::find(Auth::id());
            $action =
                "تلاش فروشگاه " .
                $shop->shop_name
                .
                " برای تایید سفارش با کد "
                .
                $request->transition_number
                .
                " ناموفق بود";
            $stat = ["action" => $action];
            $shop->stats()->create($stat);
            return 'FAILURE';
        }
    }


    public function confirmSafirOrder(Request $request)
    {
        if ($request) {
            $order = json_decode($request->order);

            foreach ($order as $item) {
                $invoice = Safinvoice::where('id', '=', $item->id)->first();
                $invoice->pending = 0;
                $invoice->porterage = $item->porterage;
                $invoice->porterage_type = $item->porterage_type;
                $invoice->inv_accept = $item->inv_accept;
                $invoice->tarh_accept = $item->tarh_accept;
                $invoice->accept_sum = $item->tarh_accept + $item->inv_accept;
//                return gettype($item->tarh_accept);
                $invoice->save();

                $book_id = Book::where('barcode', '=', $item->barcode)->first()->id;
                $shop = Shop::find($item->shop_id);

                $invoiceKey = $shop->books->where('id', '=', $book_id)->first()->pivot;

                if ($item->order_type == 1) {
                    $inventory = $invoiceKey->shop_inv - $item->tarh_accept;
                    $library = $invoiceKey->shop_lib - $item->inv_accept;
                    $sold = $invoiceKey->shop_sold + ($item->inv_accept + $item->tarh_accept);

                } elseif ($item->order_type == 2) {
                    $inventory = $invoiceKey->shop_inv + $item->tarh_accept;
                    $library = $invoiceKey->shop_lib + $item->inv_accept;
                    $sold = $invoiceKey->shop_sold - ($item->inv_accept + $item->tarh_accept);
                    $driven = $item->inv_accept + $item->tarh_accept;
                    $invoiceKey->shop_driven = $driven;
                }
                $invoiceKey->shop_inv = $inventory;
                $invoiceKey->shop_lib = $library;
                $invoiceKey->shop_sold = $sold;

                $invoiceKey->save();


            }
            return 'SUCCESS';
        } else
            return 'FAILURE';
    }

    public function inquire(Request $request)
    {
        $shop = Shop::find(Auth::id());
        $action =
            " فروشگاه " .
            $shop->shop_name
            .
            "شماره همراه یا کدملی "
            .
            $request->search_customer
            .
            " را استعلام کرد";
        $stat = ["action" => $action];
        $shop->stats()->create($stat);
        if (strlen($request->search_customer) == 10)
            $national_id = $request->search_customer;
        else $national_id = 0;

        if ($this->custom_check_national_code($national_id) || strlen($request->search_customer) == 11) {
            if ($this->custom_check_national_code($national_id))
                $customer = Customer::where('national_id', '=', $national_id)->first();
            else if (strlen($request->search_customer) == 11)
                $customer = Customer::where('tel', '=', $request->search_customer)->first();
            else
                return "INCORRECT";

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
                        "limit_setting" => $this->settings->getCustomerPercentageLimit(),
                        "percentage_setting" => $this->settings->getCustomerPercentageSetting(),
                        "customer_buy_count_limit" => $this->settings->getCustomerBuyCountLimit(),
                        "customer_buy_count_limit_per_book" => $this->settings->getCustomerBuyCountPerBook(),
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
                        "bought_count" => "0",

                        "limit_setting" => $this->settings->getCustomerPercentageLimit(),
                        "percentage_setting" => $this->settings->getCustomerPercentageSetting(),
                        "customer_buy_count_limit" => $this->settings->getCustomerBuyCountLimit(),
                        "customer_buy_count_limit_per_book" => $this->settings->getCustomerBuyCountPerBook(),
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
        $user = Shop::find(Auth::id());
        $orders = $request->orders;
        $info = $request->customer["info"];
        $national_id = $info["national_id"];
        $tel = $info["tel"];

        $isSaleValid = $this->checkCustomerBackground($orders, $national_id, $tel);
        if (!$isSaleValid) return "ORDER_LIMIT";

        //Retriving Customer For Additional Security Check. So That Client Could Not Create Duplicated Customer
        if (strlen($national_id) == 10)
            $customer = Customer::where('national_id', '=', $national_id)->first();
        else
            $customer = Customer::where('tel', '=', $tel)->first();


        //Creating New Customer If Needed
        if (!$info["is_registered"] && !$customer &&
            ($this->custom_check_national_code($info["national_id"]) ||
                (strlen($national_id) != 10 && strlen($tel) == 11))) {

            Customer::create([
                'name' => $info["name"],
                'last_name' => $info["last_name"],
                'tel' => $info["tel"],
                'national_id' => $info["national_id"],
            ]);
            if (strlen($national_id) == 10)
                $customer = Customer::where('national_id', '=', $national_id)->first();
            else
                $customer = Customer::where('tel', '=', $tel)->first();

            $user->customers()->attach($customer);

            try {
                $sender = "";
                $message = " خانم/آقای " .
                    $info["name"] . " " . $info["last_name"] .
                    " ثبت نام شما در " .
                    $this->settings->getShopTarhName() .
                    " با موفقیت انجام شد!";
                $receptor = array($info["tel"]);
                $result = Kavenegar::Send($sender, $receptor, $message);
            } catch (ApiException | HttpException $e) {
//                echo $e->errorMessage();
            }

        } elseif (!$this->custom_check_national_code($info["national_id"]) && strlen($national_id) == 10) {
            return "کد ملی وارد شده صحیح نیست";
        }

        $transition_number = (Auth::user()->id) . rand(100, 999) . (str_replace(array("-", " ", ":"), "", Carbon::now()));
        $invoice = [];
        $customer_id = $customer->id;
        $used = $customer->used;
        $bought_count = $info['bought_count'];
        $overal = 0;
        $invoiceMessage = "";
        if ($this->settings->getCustomerBuyCountLimit() == 0 || $bought_count <= $this->settings->getCustomerBuyCountLimit()) {
            return $this->processShopDirectInvoice($orders, $overal, $customer_id, $invoice, $transition_number,
                $invoiceMessage, $user, $used, $customer, $info);
        } else
            return "FAILURE";
    }

    /**
     * @param $orders
     * @param $national_id
     * @return bool
     */
    private function checkCustomerBackground($orders, $national_id, $tel): bool
    {
        $isValid = true;
        if (strlen($national_id) == 10)
            $customer = Customer::where('national_id', $national_id)->first();
        else
            $customer = Customer::where('tel', $tel)->first();

        if ($customer) {
            $customer_invoices = $customer->custinvoices()->get();
            $count = 0;
            foreach ($orders as $order) {
                foreach ($customer_invoices as $invoice) {
                    if ($order['barcode'] == $invoice['barcode']) {
                        $count = $count + $invoice['shop_lib'] + $invoice['shop_inv'];
                    }
                }
                $count = $count + $order['number_lib'] + $order['number_inv'];
                if ($count > $this->settings->getCustomerBuyCountPerBook())
                    $isValid = false;
            }
        }
        return $isValid;
    }

    /**
     * @param $orders
     * @param $overal
     * @param $customer_id
     * @param array $invoice
     * @param string $transition_number
     * @param $invoiceMessage
     * @param $user
     * @param $used
     * @param $customer
     * @param $info
     * @return string
     */
    private function processShopDirectInvoice($orders, $overal, $customer_id, array $invoice, string $transition_number, $invoiceMessage, $user, $used, $customer, $info): string
    {
        foreach ($orders as $order) {
            $book = Book::where('barcode', '=', $order["barcode"])->first();

            $overal = $overal + ($book->fee) * ($order["number_inv"] + $order["number_lib"]);

            $invoice['customer_id'] = $customer_id;
            $invoice['barcode'] = $order["barcode"];
            $invoice['book_name'] = $order["book_name"];
            $invoice['writer'] = $order["writer"];
            $invoice['publisher'] = $order["publisher"];
            $invoice['fee'] = $order["fee"];

            $invoice['shop_inv'] = $order["number_inv"];
            $invoice['shop_lib'] = $order["number_lib"];

            $invoice['order_count'] = $order["number_inv"] + $order["number_lib"];
            $invoice['transition_number'] = $transition_number;

            $invoiceMessage = $invoiceMessage . $invoice['book_name'] . " " . $invoice['order_count'] . " جلد" . "\n";
            $user->custinvoices()->create($invoice);

            $book = $user->books->where('barcode', '=', $order["barcode"])->first()->pivot;
            $book->shop_inv -= $order["number_inv"];
            $book->shop_lib -= $order["number_lib"];
            $book->shop_sold += $invoice['order_count'];
            $book->save();
        }

        $discount_raw = $overal * $this->settings->getCustomerPercentageSetting() + $used;
        $limit = $this->settings->getCustomerPercentageLimit();
        if ($discount_raw >= $limit) {
            $order_discount = $limit - $used;
            $used = $limit;
        } else {
            $order_discount = $discount_raw - $used;
            $used = $discount_raw;
        }
        $invoiceMessage = "خرید شما با مشخصات " . $invoiceMessage . "به مجموع کل " . $overal . " و تخفیف اعمال شده ی " . $order_discount .
            " و شماره پیگیری " . $transition_number . " ثبت گردید\n" .
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

        $shop = Shop::find(Auth::id());
        $action =
            " فروشگاه " .
            $shop->shop_name
            .
            " سفارش فروش مستقیم با کد "
            .
            $transition_number
            .
            " را با موفقیت ثبت کرد";
        $stat = ["action" => $action];
        $shop->stats()->create($stat);
        return "SUCCESS";
    }

    public function getAllShopCustomerOrders()
    {
        $ordersList = [];
        $invoices = Custinvoice::where('shop_id', '=', Auth::id())->get()->unique('transition_number');
        $lists = $invoices->map(function ($invoices) {
            return collect($invoices->toArray())
                ->only(['id', 'customer_id', 'transition_number',])
                ->all();
        });
        foreach ($lists as $list) {
            $customer = Customer::find($list['customer_id']);
            if ($customer != null) {
                $order = array(
                    'id' => $list['id'],
                    'customer_name' => Customer::find($list['customer_id'])->name . " " . Customer::find($list['customer_id'])->last_name,
                    'transition_number' => $list['transition_number'],
                    'tel' => $customer->tel,
                );

                array_push($ordersList, $order);
            }
        }
        return $ordersList;

    }

    public function sendCustomerOrder(Request $request)
    {
        $order = Custinvoice::where('transition_number', '=', $request->transition_number)->get();
        return $order;
    }

    public function sendCustomerAndSeller(Request $request)
    {
        $transition_number = $request->transition_number;
        $custinvoice = Custinvoice::where('transition_number', '=', $transition_number)->first();
        $shop = $custinvoice->shop->only(['name', 'last_name', 'shop_name', 'shop_tel']);
        $customer = $custinvoice->customer->only(['name', 'last_name', 'national_id', 'tel']);
        return ["seller" => $shop, "customer" => $customer];
    }

}
