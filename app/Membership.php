<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    public function smshistories() {
      return $this->hasMany('App\Smshistory');
    }
}
