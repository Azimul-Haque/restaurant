<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qikstock extends Model
{
    public function qikusages() {
      return $this->hasMany('App\Qikusage');
    }
}
