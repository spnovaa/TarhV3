<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Morilog\Jalali\Jalalian;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'tel', 'last_name'
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

    protected $appends = ['jalali_created_at', 'jalali_updated_at', 'last_tarh'];

    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot(['safir_sold', 'safir_inv'])->withTimestamps();
    }

    public function safinvoices()
    {
        return $this->hasMany(Safinvoice::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class)->withTimestamps();
    }

    public function custinvoices()
    {
        return $this->hasMany(Custinvoice::class);
    }

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }

    public function getJalaliCreatedAtAttribute(): string
    {
        return Jalalian::fromDateTime($this->created_at)->format('Y-m-d');
    }

    public function getJalaliUpdatedAtAttribute()
    {
        return Jalalian::fromDateTime($this->updated_at)->format('Y-m-d');
    }

    public function getLastTarhAttribute()
    {
        return (is_null($this->updated_at) || $this->updated_at > '2022-01-01') ? "سفیرحسینی3": "سفیرحسینی2";
    }
}
