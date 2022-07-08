<?php

namespace App\Http\Controllers\Admin;

use App\Distributor;
use App\UserStats;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\User;
use App\Shop;

class BookController extends Controller
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
                    'inventory' => $book->dist_inv,
                );
                array_push($bookList, $info);
            }
        }

        return $bookList;

    }

    public function updateList(Request $request)
    {
        $data = json_decode($request->books);
        $bookList = [];
        foreach ($data as $book) {
            $book_model = Book::get();
            if (isset($book->edited) && $book->edited > 0) {

                $book_data = Book::firstOrCreate([
                    'barcode' => $book->barcode,
                ]);
                $book_data->book_name = $book->book_name;
                $book_data->writer = $book->writer;
                $book_data->publisher = $book->publisher;
                $book_data->fee = $book->fee;
                $book_data->editor = "مدیریت";
                $book_data->edited = 0;
                if ($book_data->deleted == true) {
                    $book_data->deleted == false;
                }
                $book_data->save();
                if ($book->editType == 1) {
                    $shops = Shop::where('sent_flag', '=', 1)->get();
                    $distributors = Distributor::get();
                    $book = Book::where('barcode', '=', $book->barcode)->first();

                    foreach ($shops as $shop) {
//                        $shop->books()->attach($book);
                        $shop->books()->syncWithoutDetaching($book);

                    }

                    foreach ($distributors as $distributor) {
//                        $distributor->books()->attach($book);
                        $distributor->books()->syncWithoutDetaching($book);

                    }
                }

            }

        }
        return "SUCCESS";
    }

    public function deleteBook(Request $request)
    {
        $book = Book::find($request->id);
        $book->deleted = true;
        $book->save();
        return "SUCCESS";
    }

    public function getUserStats()
    {
        $userStats = new UserStats();
        return $userStats->getStats();
    }
}
