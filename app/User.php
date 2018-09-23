<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    
    public function commodities() {
      return $this->hasMany('App\Commodity');
    }

    public function stocks() {
      return $this->hasMany('App\Commodity');
    }

    public function usages() {
      return $this->hasMany('App\Commodity');
    }

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
