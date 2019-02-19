<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Session;

use App\Stuff;
use App\Stuffpayment;

class StuffController extends Controller
{
    public function __construct() 
    {
      parent::__construct();
    }

    public function index()
    {
        $stuffs = Stuff::all();
        $stuffpayments = Stuffpayment::orderBy('id', 'desc')->paginate(20);
        return view('stuffs.index')
                    ->withStuffs($stuffs)
                    ->withStuffpayments($stuffpayments);
    }

    public function store(Request $request)
    {
        //validation
        $this->validate($request, array(
            'name'=>'required|max:255|unique:stuffs,name'
        ));

        //store to DB
        $stuff = new Stuff;
        $stuff->name = $request->name;
        $stuff->save();

        Session::flash('success', 'A new Stuff has been created successfully!');
        //redirect
        return redirect()->route('stuffs.index');
    }

    public function update(Request $request, $id)
    {
        $stuff = Stuff::find($id);
        //validation
        if($stuff->name == $request->name) {
          $this->validate($request, array(
              'name'=>'required|max:255'
          ));
        } else {
          $this->validate($request, array(
              'name'=>'required|max:255|unique:stuffs,name'
          ));
        }
        
        //store to DB
        $stuff->name = $request->name;
        $stuff->save();

        Session::flash('success', 'Stuff name updated successfully!');
        //redirect
        return redirect()->route('stuffs.index');
    }

    public function staffPayment(Request $request)
    {
        //validation
        $this->validate($request, array(
            'stuff_id' => 'required',
            'amount'   => 'required|max:255'
        ));

        //store to DB
        $stuffpayment = new Stuffpayment;
        $stuffpayment->stuff_id = $request->stuff_id;
        $stuffpayment->amount = $request->amount;
        $stuffpayment->save();

        Session::flash('success', 'Payment added successfully!');
        //redirect
        return redirect()->route('stuffs.index');
    }

    public function updatePayment(Request $request, $id)
    {
        //validation
        $this->validate($request, array(
            'amount'   => 'required|max:255'
        ));
        
        //store to DB
        $stuffpayment = Stuffpayment::find($id);
        $stuffpayment->amount = $request->amount;
        $stuffpayment->save();

        Session::flash('success', 'Payment updated successfully!');
        //redirect
        return redirect()->route('stuffs.index');
    }

    public function destroyPayment($id)
    {
        $stuffpayment = Stuffpayment::find($id);
        $stuffpayment->delete();

        Session::flash('success', 'Payment deleted successfully!');
        //redirect
        return redirect()->route('stuffs.index');
    }
}
