<?php


namespace App\Http\Controllers\Admin;


use App\Custinvoice;
use App\HelperClasses\Admin\Excel\Admin\stats\shops\ShopsSell;
use App\HelperClasses\Admin\Excel\Shop\ShopsBooksSellExcel;
use App\HelperClasses\Admin\Excel\Shop\ShopsTotalSellExcel;
use App\HelperClasses\General\BookStat;
use App\HelperClasses\Shop\DirectStatsExport;
use App\Http\Controllers\Controller;
use App\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StatsController extends Controller
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


    public function getShopDirectSellStats(Request $request)
    {
        $statID = 0;
        $booksStats = array();
//        $shopInvoices = Custinvoice::where('shop_id','=', $request)->get()
//            ->only(['barcode', 'book_name', 'writer', 'publisher', 'fee', 'order_count', 'order_discount']);
        $invoices = Custinvoice::where('shop_id', '=', $request->id)->get();

        $shopInvoices = $invoices->map(function ($invoices) {
            return collect($invoices->toArray())
                ->only(['barcode', 'book_name', 'writer', 'publisher', 'fee', 'order_count', 'order_discount'])
                ->all();
        });
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
        return $booksStats;
    }

    public function getShopDirectSellStatsExcel()
    {
        return Excel::download(new DirectStatsExport(), 'directStats.xlsx');
    }

    public function getShopTotalSell()
    {
        return Custinvoice::whereNotNull('shop_id')->sum('order_count');
    }

    public function getShopsBooksSellExcel()
    {
        return Excel::download(new ShopsBooksSellExcel(), 'shopsBooksSellStat.xlsx');
    }

    public function getShopsBooksSellData()
    {
        return DB::table('custinvoices')
            ->join('books', 'custinvoices.barcode', '=', 'books.barcode')
            ->join('shops', 'shops.id', '=', 'custinvoices.shop_id')
            ->selectRaw('shop_name, books.book_name, SUM(order_count) as sum')
            ->groupBy(['shops.shop_name', 'books.book_name'])
            ->get();
    }

    public function getShopsTotalSellExcel()
    {
        return Excel::download(new ShopsTotalSellExcel(), 'shopsTotalSellStat.xlsx');
    }

    public function getShopsTotalSellData()
    {
        return DB::table('custinvoices')
            ->join('books', 'custinvoices.barcode', '=', 'books.barcode')
            ->join('shops', 'shops.id', '=', 'custinvoices.shop_id')
            ->selectRaw('shop_name, SUM(order_count) as sum')
            ->groupBy('shops.shop_name')
            ->get();
    }
}
