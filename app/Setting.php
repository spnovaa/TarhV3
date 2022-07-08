<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Notifiable;
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tarh_name', //'safir_active', 'shop_active', 'dist_active', 'shop_lib_sell_active','shop_direct_sell_active',
        // 'safir_percentage', 'shop_percentage', 'dist_percentage', 'customer_percentage', 'customer_percentage_limit'
    ];
}
