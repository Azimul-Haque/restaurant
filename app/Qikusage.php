<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qikusage extends Model
{
    public function qikstock() {
      return $this->belongsTo('App\Qikstock');
    }
}
