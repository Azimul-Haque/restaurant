<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Membership;
use Artisan;

class IndexController extends Controller
{
    public function index()
    {
      return view('index.welcome');
    }

    public function getMemberAPI($phone)
    {
      try {
        $member = Membership::where('phone', $phone)->first();
        if($member == true) {
          return $member;
        } else {
          return 'N/A';
        }
      }
      catch (\Exception $e) {
        return 'N/A';
      }
    }

    // clear configs, routes and serve
    public function clear()
    {
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        echo 'Config and Route Cached. All Cache Cleared';
    }
}
