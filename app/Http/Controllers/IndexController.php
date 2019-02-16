<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Membership;
use App\Aboutus;
use App\Menu;
use App\Slider;

use Artisan;
use Session;

class IndexController extends Controller
{
    public function index()
    {
      $aboutus = Aboutus::find(1);
      $menus = Menu::orderBy('updated_at', 'desc')->get()->take(7);
      $allmenus = Menu::orderBy('id', 'desc')->get();
      $lasttwomenus = Menu::orderBy('updated_at', 'desc')->get()->take(2);
      $sliders = Slider::all();
      $sixsliders = Slider::orderBy('updated_at', 'desc')->get()->take(6);

      return view('index.welcome')
                        ->withAboutus($aboutus)
                        ->withMenus($menus)
                        ->withAllmenus($allmenus)
                        ->withLasttwomenus($lasttwomenus)
                        ->withSliders($sliders)
                        ->withSixsliders($sixsliders);
    }

    public function subscribe(Request $request)
    {
      //validation
      $this->validate($request, array(
          'name'=>'required|max:255',
          'phone' => 'required|max:11|unique:memberships,phone',
          'captchasum'=>'required',
          'hiddencaptchasum'=>'required'
      ));

      if($request->captchasum != $request->hiddencaptchasum) {
        Session::flash('warning', 'যোগফল ভুল হয়েছে! আবার চেষ্টা করুন।');
      } else {
        $member = new Membership;
        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->point = 0;
        $member->type = 0;
        $member->awarded = 0;
        $member->isdeleted = 0;
        $member->save();

        Session::flash('success', 'সফলভাবে সাবস্ক্রাইব করবার জন্য ধন্যবাদ!');
      }
      return redirect()->route('index.index');
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
        // Artisan::call('route:cache');
        Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('key:generate');
        Session::flush();
        echo 'Config and Route Cached. All Cache Cleared';
    }
}
