<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Membership;

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
}
