<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smshistory extends Model
{
    public function membership() {
      return $this->belongsTo('App\Membership');
    }
}
