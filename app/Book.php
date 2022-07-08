<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Book extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_name', 'writer', 'publisher', 'fee', 'barcode', 'sold', 'edited'
    ];

    public function shops()
    {
        return $this->belongsToMany(Shop::class)->withPivot(['shop_sold', 'shop_driven', 'shop_inv', 'shop_lib'])->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['safir_sold', 'safir_inv'])->withTimestamps();
    }

    public function distributors()
    {
        return
            $this->
            belongsToMany(Distributor::class)->
            withPivot(['dist_inv', 'dist_sold', 'dist_driven', 'dist_entry'])->
            withTimestamps();
    }

    public function distributorShopInvoices()
    {
        return
            $this->
            belongsToMany(DistributorShopInvoice::class)->
            withPivot(['count', 'dist_accept', 'row_sum', 'discount_percentage', 'dist_disc_percent'])->
            withTimestamps();
    }

}
