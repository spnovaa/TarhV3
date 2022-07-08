<?php

namespace App\Http\Controllers\Distributor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Shop;
use App\Sinvoice;
use \stdClass;
use Auth;
class OrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:distributor');
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
        $company = Auth::user();
        $shop = Shop::class;
        $ordersList = [];
        $invoices = Sinvoice::where('distributor_id', $company->id)->get()->unique('transition_number');
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

    public function getOrder(Request $request)
    {
        $company = Auth::user();
        $orders = Sinvoice::where('transition_number', '=', $request->transition_number)->
        where('distributor_id', $company->id)->get();
        $items = [];
        foreach ($orders as $item) {
            $item->dist_seen = 1;
            $item->save();
            $company_remaining = $company->books()->where('barcode', $item->barcode)->first()->pivot->dist_inv;
            $item_to_push = $item->toArray() + ['dist_inv' => $company_remaining];
            array_push($items, $item_to_push);
        }


        return $items;
    }

    public function confirmOrder(Request $request)
    {
        $dist = Auth::user();
        if ($request) {
            $order = json_decode($request->order);
            foreach ($order as $item) {
                $invoice = Sinvoice::where('id', '=', $item->id)->first();
                $invoice->pending = 0;
                $invoice->porterage = $item->porterage;
                $invoice->porterage_type = $item->porterage_type;
                $invoice->dist_accept = $item->dist_accept;
                $invoice->order_discount = intval($item->dist_accept * $item->fee * $item->order_disc_percent / 100);

                $invoice->save();
                $book = $dist->books->where('barcode', '=', $item->barcode)->first()->pivot;

                if ($item->order_type == 1) {
                    $book->dist_inv = $book->dist_inv - $item->dist_accept;
                    $book->dist_sold = $book->dist_sold + $item->dist_accept;
                } elseif ($item->order_type == 2) {
                    $book->dist_inv = $book->dist_inv + $item->dist_accept;
                    $book->dist_driven = $book->dist_inv + $item->dist_accept;
                }
                $book->save();
            }
            return 'SUCCESS';
        } else
            return 'FAILURE';
    }
}
