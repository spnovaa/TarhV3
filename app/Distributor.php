<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Distributor extends Authenticatable
{
    use Notifiable;

    protected $guard = 'distributor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tel', 'password', 'admin_accept', 'active', 'company_name'
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
            withPivot(['dist_inv', 'dist_sold', 'dist_driven', 'dist_entry', 'dist_disc_percent'])->
            withTimestamps();
    }

    public function shops()
    {
        return
            $this->
            belongsToMany(Shop::class)->
            withPivot(['net_balance', 'porterage_balance'])->
            withTimestamps();
    }

    public function distFinancialProfile()
    {
        return $this->hasOne(DistFinancialProfile::class);
    }

    public function distProfile()
    {
        return $this->hasOne(DistProfile::class);
    }

    public function distributorShopInvoices()
    {
        return $this->hasMany(DistributorShopInvoice::class);
    }

    public function distRecentActions()
    {
        return $this->hasMany(DistRecentAction::class);
    }
}
