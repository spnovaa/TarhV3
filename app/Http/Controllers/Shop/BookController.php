<?php

namespace App\Http\Controllers\Shop;

use App\Distributor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Shop;
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
        $this->middleware('auth:shop');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getDistInventory(Request $request)
    {
        $response = [];
        $dist_id = $request->dist_id;
        $dist = Distributor::find($dist_id);
        $bookList = $dist->books->where('deleted', '=', false);
        array_push($response, $bookList);
        $company_name = $dist->company_name;
        array_push($response, $company_name);
        return $response;
    }

    public function getAllData()
    {
        $bookList = [];
        $books = Book::get();
        foreach ($books as $book) {
            if ($book->deleted == false) {
                $info = array(
                    'id' => $book->id,
                    'book_name' => $book->book_name,
                    'writer' => $book->writer,
                    'publisher' => $book->publisher,
                    'fee' => $book->fee,
                    'barcode' => $book->barcode,
                    'editor' => $book->editor,
                    'edited' => $book->edited,
                );
                array_push($bookList, $info);
            }
        }
        return $bookList;
    }

    public function updateList(Request $request)
    {
        $data = json_decode($request->books);

        foreach ($data as $book) {
            if ($book->edited) {

                //save book to book table
                $this->saveBookToBooks($book);

                //assign book to other roles pivot so they can access to it
                $this->assignBookToShopsAndDists($book);

                //if book has initial shop lib inventory, save that to it's pivot
                if (isset($book->shop_lib)) $this->addInitialLib($book);

            }
        }
        return "SUCCESS";
    }

    /**
     * @param $book
     */
    private function saveBookToBooks($book): void
    {
        $book_data = Book::firstOrCreate([
            'barcode' => $book->barcode,
        ]);
        $book_data->book_name = $book->book_name;
        $book_data->writer = $book->writer;
        $book_data->publisher = $book->publisher;
        $book_data->fee = $book->fee;
        $book_data->editor = Auth::user()->name . " " . Auth::user()->last_name;
        $book_data->edited = 0;
        $book_data->save();
    }

    /**
     * @param $book
     */
    private function assignBookToShopsAndDists($book)
    {
        $shops = Shop::where('sent_flag', '=', 1)->get();
        $book = Book::where('barcode', '=', $book->barcode)->first();
        $dists = Distributor::where("sent_resume", 1)->get();

        foreach ($shops as $shop) {
            $shop->books()->syncWithoutDetaching($book);
        }
        foreach ($dists as $dist) {
            $dist->books()->syncWithoutDetaching($book);
        }
    }

    /**
     * saves book initial value to its related pivot for shop
     * @param $book
     */
    private function addInitialLib($book)
    {
        $shop = Shop::find(Auth::id());
        $book_id = $this->findBookIdByBarcode($book->barcode);
        $shop_item = $shop->books->where('id', $book_id)->first();
        if ($shop_item != null) {
            $itemPivot = $shop_item->pivot;
            $itemPivot->shop_lib = $book->shop_lib;
            $itemPivot->save();

            $action =
                " فروشگاه " .
                $shop->shop_name
                .
                " موجودی فروشگاه برای کتاب "
                .
                $book->book_name
                .
                " را به "
                .
                $book->shop_lib
                .
                "تغییر داد";
            $stat = ["action" => $action];
            $shop->stats()->create($stat);
        }

    }

    /**
     * searches for the book by it's barcode number and returns the first match
     * @param $barcode
     * @return mixed book
     */
    private function findBookIdByBarcode($barcode)
    {
        return Book::where('barcode', $barcode)->first()->id;
    }

}
