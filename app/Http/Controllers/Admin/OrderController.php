<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Shop;
use App\Sinvoice;
use App\Safinvoice;
use App\Custinvoice;
use App\User;
use App\Customer;
use \stdClass;

class OrderController extends Controller
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


    // public function updateList(Request $request)
    // {

    //     $data=json_decode($request->books);
    //     $bookList=[];
    //     foreach($data as $book){
    //         $book_model=Book::get();
    //         if(isset($book->edited) && $book->edited){
    //             $book_data = Book::firstOrCreate([
    //                 'barcode'       =>      $book->barcode,
    //             ]);
    //             $book_data->dist_inv   = $book->inventory;

    //             $book_data->edited      =      0;

    //             $book_data->save();

    //         }

    //     }
    //     return "SUCCESS";
    // }
    // public function deleteBook(Request $request)
    // {
    //     $book = Book::find($request->id);
    //     $book->delete();
    //     return "SUCCESS";
    // }
    public function getAllOrders()
    {
        $shop = Shop::class;
        $ordersList = [];
        $invoices = Sinvoice::get()->unique('transition_number');
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
                    'جدید' :
                    'بررسی شده'
            );

            array_push($ordersList, $order);
        }
        return $ordersList;

    }


    public function getDistributorOrder(Request $request)
    {
        $order = Sinvoice::where('transition_number', '=', $request->transition_number)->get();

        return $order;
    }

    public function getAllSafirShopOrders()
    {
        $shop = Shop::class;
        $user = User::class;
        $ordersList = [];
        $invoices = Safinvoice::get()->unique('transition_number');
        $lists = $invoices->map(function ($invoices) {
            return collect($invoices->toArray())
                ->only(['id', 'shop_id', 'user_id', 'transition_number', 'order_type', 'pending', 'porterage', 'porterage_type'])
                ->all();
        });
        foreach ($lists as $list) {

            $order = array(
                'id' => $list['id'],
                'shop_name' => Shop::find($list['shop_id'])->shop_name,
                'safir_name' => User::find($list['user_id'])->name . " " . User::find($list['user_id'])->last_name,
                'transition_number' => $list['transition_number'],
                'porterage' => $list['porterage'],
                'porterage_type' => $list['porterage_type'],
                'order_type' => $list['order_type'] == 1 ?
                    'خرید' :
                    'مرجوعی',

                'status' => $list['pending'] == 1 ?
                    'جدید' :
                    'بررسی شده'
            );

            array_push($ordersList, $order);
        }
        return $ordersList;
    }

    public function getAllCustomerOrders()
    {
        $customer = Customer::class;
        $ordersList = [];
        $invoices = Custinvoice::get()->unique('transition_number');
        $lists = $invoices->map(function ($invoices) {
            return collect($invoices->toArray())
                ->only(['id', 'customer_id', 'user_id', 'shop_id', 'transition_number',])
                ->all();
        });
        foreach ($lists as $list) {
            $shop_name = Shop::find($list['shop_id']) ? Shop::find($list['shop_id'])->shop_name : "";
            $safir_name = User::find($list['user_id']) ? User::find($list['user_id'])->name . " " . User::find($list['user_id'])->last_name : "";
            $order = array(
                'id' => $list['id'],
                'customer_name' => Customer::find($list['customer_id'])->name . " " . Customer::find($list['customer_id'])->last_name,
                'shop_name' => $shop_name,
                'safir_name' => $safir_name,
                'transition_number' => $list['transition_number'],
                'tel' => Customer::find($list['customer_id'])->tel,
            );

            array_push($ordersList, $order);
        }
        return $ordersList;

    }

    public function getSafirShopOrder(Request $request)
    {
        $order = Safinvoice::where('transition_number', '=', $request->transition_number)->get();
        return $order;
    }

    public function sendCustomerOrder(Request $request)
    {
        return Custinvoice::where('transition_number', '=', $request->transition_number)->get();
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
