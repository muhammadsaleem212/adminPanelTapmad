<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promoCode extends Model
{
    //
    protected $fillable = [
        'offerID','promoCode'
    ];
    protected $table = 'promoCode';
}
