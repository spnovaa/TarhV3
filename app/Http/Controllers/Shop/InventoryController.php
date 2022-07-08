<?php

namespace App\Http\Controllers\Shop;

use App\Custinvoice;
use App\HelperClasses\General\BookStat;
use App\HelperClasses\Shop\DirectStatsExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Shop;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:shop');
    }

    public function getInventory()
    {
        $shop = Shop::find(Auth::id());
        $bookList = $shop->books()->where('deleted', '=', false)->get();
        return $bookList;

    }

    public function updateList(Request $request)
    {
        $data = json_decode($request->books);

        $shop = Shop::find(Auth::id());

        foreach ($data as $item) {
            $book_id = $item->id;
            $itemPivot = $shop->books->where('id', '=', $book_id)->first()->pivot;
            $itemPivot->shop_lib = $item->pivot->shop_lib;
            $itemPivot->save();

            $action =
                " فروشگاه " .
                $shop->shop_name
                .
                " موجودی فروشگاه برای کتاب "
                .
                $item->book_name
                .
                " را به "
                .
                $item->pivot->shop_lib
                .
                "تغییر داد";
            $stat = ["action" => $action];
            $shop->stats()->create($stat);
        }
        return "SUCCESS";
    }

    public function getShopDirectSellStats()
    {
        $statID = 0;
        $shop = Shop::find(Auth::id());
        $booksStats = array();
        $shopInvoices = $shop->custinvoices->map
            ->only(['barcode', 'book_name', 'writer', 'publisher', 'fee', 'order_count', 'order_discount']);
        foreach ($shopInvoices as $shopInvoice) {
            $isItemInList = false;
            foreach ($booksStats as $booksStat) {
                if ($booksStat != null && $booksStat->barcode == $shopInvoice['barcode']) {
                    $booksStat->sellCount += $shopInvoice['order_count'];
                    $booksStat->sellAmount += $shopInvoice['order_count'] * $shopInvoice['fee'] - $shopInvoice['order_discount'];
                    $isItemInList = true;
                }
            }
            if (!$isItemInList) {
                $stat = new BookStat($statID, $shopInvoice['barcode'], $shopInvoice['book_name'], $shopInvoice['fee'], $shopInvoice['publisher'], $shopInvoice['order_count'], $shopInvoice['order_discount']);
                $statID++;
                array_push($booksStats, $stat);
            }
        }

        $action =
            " فروشگاه " .
            $shop->shop_name
            .
            " آمار فروش مستقیم خود را مشاهده کرد";
        $stat = ["action" => $action];
        $shop->stats()->create($stat);
        return $booksStats;
    }

    public function getShopDirectSellStatsExcel()
    {
        return Excel::download(new DirectStatsExport(), 'directStats.xlsx');
    }
}
