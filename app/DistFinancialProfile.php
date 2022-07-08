<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistFinancialProfile extends Model
{
    protected $guard = 'distributor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shaba_id', 'percentage',
    ];

    public function distributor()
    {
        return
            $this->belongsTo(DistFinancialProfile::class);
    }
}
