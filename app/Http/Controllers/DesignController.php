<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Session;
use Auth;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Aboutus;
use App\Menu;
use App\Slider;

use Image;
use File;

class DesignController extends Controller
{
    public function __construct() 
    {
      parent::__construct();
    }
    
    public function index()
    {
        $aboutus = Aboutus::find(1);
        $menus = Menu::orderBy('id', 'desc')->paginate(7);
        $sliders = Slider::orderBy('id', 'desc')->paginate(5);

        return view('design.index')
                            ->withAboutus($aboutus)
                            ->withMenus($menus)
                            ->withSliders($sliders);
    }

    public function storeAboutUs(Request $request)
    {
        //validation
        $this->validate($request, array(
            'text'=>'required'
        ));

        //store to DB
        $aboutus = Aboutus::find(1);
        $aboutus->text = $request->text;
        $aboutus->save();

        Session::flash('success', 'Updated successfully!');
        return redirect()->route('design.index');
    }

    public function storeMenuItem(Request $request)
    {
        //validation
        $this->validate($request, array(
            'item'=>'required|max:255',
            'price'=>'required|max:255',
            'description'=>'required|max:255'
        ));

        //store to DB
        $menu = New Menu;
        $menu->item = $request->item;
        $menu->price = $request->price;
        $menu->description = $request->description;
        $menu->save();

        Session::flash('success', 'Added successfully!');
        return redirect()->route('design.index');
    }

    public function updateMenuItem($id, Request $request)
    {
        //validation
        $this->validate($request, array(
            'item'=>'required|max:255',
            'price'=>'required|max:255',
            'description'=>'required|max:255'
        ));

        //update to DB
        $menu = Menu::find($id);
        $menu->item = $request->item;
        $menu->price = $request->price;
        $menu->description = $request->description;
        $menu->save();

        Session::flash('success', 'Updated successfully!');
        return redirect()->back();
    }

    public function destroyMenuItem($id)
    {
        $menu = Menu::find($id);
        $menu->delete();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->back();
    }

    public function storeSliderImg(Request $request)
    {
        //validation
        $this->validate($request, array(
            'item'=>'required|max:255',
            'description'=>'required|max:255',
            'image'=>'required|image|max:200'
        ));

        //store to DB
        $slider = New Slider;
        $slider->item = $request->item;
        $slider->description = $request->description;

        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/slider/'. $filename);
            Image::make($image)->resize(300, 250)->save($location);
           $slider->image = $filename;
        }

        $slider->save();

        Session::flash('success', 'Uploaded successfully!');
        return redirect()->route('design.index');
    }

    public function destroySliderImage($id)
    {
        $slider = Slider::find($id);
        $image_path = public_path('images/slider/'. $slider->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $slider->delete();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->back();
    }
}
