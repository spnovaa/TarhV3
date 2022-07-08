<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorShopInvoice extends Model
{
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function books()
    {
        return
            $this->
            belongsToMany(Book::class)->
            withPivot(['count', 'dist_accept', 'row_sum', 'discount_percentage'])->
            withTimestamps();
    }
}
