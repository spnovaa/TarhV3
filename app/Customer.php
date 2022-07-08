<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function shops()
    {
        return $this->belongsToMany(Shops::class)->withTimestamps();
    }

    public function custinvoices()
    {
        return $this->hasMany(Custinvoice::class);
    }

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }
}
