<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stuffpayment extends Model
{
    public function stuff() {
      return $this->belongsTo('App\Stuff');
    }
}
