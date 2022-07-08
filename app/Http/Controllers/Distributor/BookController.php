<?php

namespace App\Http\Controllers\Distributor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Shop;
use App\Distributor;
use Auth;

class BookController extends Controller
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

    public function getAllData()
    {
        $dist = Distributor::find(Auth::id());
        try {
            return $dist->books->where('deleted', false);
        } catch (\Illuminate\Database\QueryException $ex) {
            return [];
        }
    }

    public function updateList(Request $request)
    {
        $data = json_decode($request->books);
        $bookList = [];
        $dist = Auth::user();

        $dist_books = $dist->books()->get();

        foreach ($data as $item) {

            if (isset($item->edited) && $item->edited) {
                $book = $dist->books->where('barcode', '=', $item->barcode)->first()->pivot;
                $book->dist_inv = $item->dist_inv;
                $book->dist_disc_percent = $item->dist_disc_percent;
                $book->save();
            }

        }
        return "SUCCESS";
    }

    public function deleteBook(Request $request)
    {
        $book = Book::find($request->id);
        $book->delete();
        return "SUCCESS";
    }

    public function getAllShopData()
    {
        $resumeList = [];
        $Resume = Shop::where('admin_accept', '=', 1)->get();
        $info = array(
            'id' => $Resume[0]->id,
            'name' => $Resume[0]->name,
            'last_name' => $Resume[0]->last_name,
            'shop_name' => $Resume[0]->shop_name,
            'tel' => $Resume[0]->tel,
            'address' => $Resume[0]->living_state . "، " . $Resume[0]->living_city . "، " . $Resume[0]->living_area . "، خیابان " . $Resume[0]->living_street
        );
        array_push($resumeList, $info);
        return $resumeList;
    }
}
