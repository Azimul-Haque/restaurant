<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, Input, Redirect, Session;

use App\Qikstock;
use App\Qikusage;
use Auth;

class QikstockController extends Controller
{
    public function index()
    {
        $stocks = Qikstock::orderBy('name', 'asc')->get();

        return view('qikstocks.index')
                    ->withStocks($stocks);
    }

    public function getQIKUsage()
    {
        // $stocks = Qikstock::orderBy('name', 'asc')->get();

        // $stock_id = array();
        // foreach ($stocks as $stock) {
        //   $stock_id[] = $stock->id;
        // }
        
        $usages = Qikusage::orderBy('created_at', 'desc')->get();
        // $newusages = [];
        // foreach($stocks as $stock) {
        //     foreach($usages as $usage) {
        //         if($stock->name == $usage->qikstock->name) {
        //             array_push($newusages, $usage);
        //         }
        //     }
        // }
        // dd($newusages);
        return view('qikusages.index')
                    ->withUsages($usages);
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
          'name'=>'required|max:255|unique:qikstocks,name',
          'unit'=>'required|max:255',
          'quantity'=>'required|numeric|min:0'
        ));

        $stock = new Qikstock;
        $stock->name = $request->name;
        $stock->unit = $request->unit;
        $stock->quantity = $request->quantity;
        $stock->save();
        
        Session::flash('success', 'QIK Stock added successfully!');
        //redirect
        return redirect()->route('qikstocks.index');
    }

    public function update(Request $request, $id)
    {
        $stock = Qikstock::find($id);

        if($stock->name == $request->name) {
          $this->validate($request, array(
            'name'=>'required|max:255',
            'unit'=>'required|max:255',
            'quantity'=>'required|numeric|min:0'
          ));
        } else {
          $this->validate($request, array(
            'name'=>'required|max:255|unique:qikstocks,name',
            'unit'=>'required|max:255',
            'quantity'=>'required|numeric|min:0'
          ));
        }
      
        $stock->name = $request->name;
        $stock->unit = $request->unit;
        $stock->quantity = $request->quantity;
        $stock->save();
        
        Session::flash('success', 'QIK Stock updated successfully!');
        //redirect
        return redirect()->route('qikstocks.index');
    }

    public function storeUsage(Request $request)
    {
        $this->validate($request, array(
          'qikstock_id'=>'required',
          'quantity'=>'required|numeric|min:0'
        ));

        $stock = Qikstock::find($request->qikstock_id);
        $stock->quantity = $stock->quantity - $request->quantity;
        $stock->save();

        $usage = new Qikusage;
        $usage->qikstock_id = $request->qikstock_id;
        $usage->quantity = $request->quantity;
        $usage->save();
        
        Session::flash('success', 'QIK Usage added successfully!');
        //redirect
        return redirect()->route('qikstocks.index');
    }

    public function getQIKStockUnitAPI($id)
    {
        try {
          $qikstockunit = Qikstock::find($id);
          return $qikstockunit->unit;
        }
        catch (\Exception $e) {
          return 'N/A';
        }
    }

    public function getQIKStockMaxAPI($id)
    {
        try {
          $qikstockmax = Qikstock::find($id);
          return $qikstockmax->quantity;
        }
        catch (\Exception $e) {
          return 'N/A';
        }
    }
}
