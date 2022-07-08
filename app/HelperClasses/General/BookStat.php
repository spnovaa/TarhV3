<?php


namespace App\HelperClasses\General;


class BookStat
{
    public $id;
    public $barcode;
    public $book_name;
    public $fee;
    public $publisher;
    public $sellCount;
    public $sellAmount;

    /**
     * BookStat constructor.
     * @param $id
     * @param $barcode
     * @param $book_name
     * @param $fee
     * @param $publisher
     * @param $sellCount
     * @param $order_discount
     */
    public function __construct($id, $barcode, $book_name, $fee, $publisher, $sellCount, $order_discount)
    {
        $this->id = $id;
        $this->barcode = $barcode;
        $this->book_name = $book_name;
        $this->fee = $fee;
        $this->publisher = $publisher;
        $this->sellCount = $sellCount;
        $this->sellAmount = $sellCount * $fee - $order_discount;
    }


}
