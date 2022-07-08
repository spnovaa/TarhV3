<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DistProfile extends Model
{
    use Notifiable;

    protected $guard = 'distributor';

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
