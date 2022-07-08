<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Shop extends Authenticatable
{
    use Notifiable;
    protected $guard = 'shop';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'password', 'tel', 'shop_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function books()
    {
        return
            $this->
            belongsToMany(Book::class)->
            withPivot(['shop_sold', 'shop_driven', 'shop_inv', 'shop_lib'])->
            withTimestamps();
    }

    public function distributor()
    {
        return
            $this->
            belongsToMany(Distributor::class)->
            withPivot(['net_balance', 'porterage_balance'])->
            withTimestamps();
    }

    public function sinvoices()
    {
        return $this->hasMany(Sinvoice::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class)->withTimestamps();
    }

    public function custinvoices()
    {
        return $this->hasMany(Custinvoice::class);
    }

    public function distributorShopInvoices()
    {
        return $this->hasMany(DistributorShopInvoice::class);
    }

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }
}
