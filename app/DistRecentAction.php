<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistRecentAction extends Model
{
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
