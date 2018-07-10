<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function commodities() {
      return $this->hasMany('App\Commodity');
    }
}
