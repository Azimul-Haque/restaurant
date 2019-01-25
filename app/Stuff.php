<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stuff extends Model
{
    public function stuffpayments() {
      return $this->hasMany('App\Stuffpayment');
    }
}
