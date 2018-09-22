<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, Input, Redirect, Session;
use App\Category;
use App\Commodity;
use App\Stock;
use Auth;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commodities = Commodity::all();

        $categories = Category::all();

        return view('commodities.index')
                    ->withCommodities($commodities)
                    ->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // COMMODITY PART
        //validation
        $this->validate($request, array(
          'category_id' => 'required|integer',
          'quantity'=>'required|numeric',
          'total'=>'required|numeric'
        ));
       
        //store to DB
        $commodity = new Commodity;
        $commodity->category_id = $request->category_id;
        $commodity->user_id = Auth::user()->id;
        $commodity->quantity = $request->quantity;
        $commodity->total = $request->total;
        $commodity->save();

        // STOCK PART
        //validation
        $stock = Stock::where('category_id', $request->category_id)->first();
        // dd($stock);
        if($stock !== null) {
          $this->validate($request, array(
              'category_id' => 'required|integer',
              'quantity'=>'required|numeric'
          ));
          //update to DB
          $stock->user_id = Auth::user()->id;
          $stock->quantity = $stock->quantity + $request->quantity;
        } elseif($stock == null) {
          $this->validate($request, array(
              'category_id' => 'required|integer|unique:stocks,category_id',
              'quantity'=>'required|numeric'
          ));
          //store to DB
          $stock = new Stock;
          $stock->category_id = $request->category_id;
          $stock->user_id = Auth::user()->id;
          $stock->quantity = $request->quantity;
        }
        
        $stock->save();
        // STOCK PART

        Session::flash('success', 'A new Commodity has been created successfully!');
        //redirect
        return redirect()->route('commodities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $commodity = Commodity::find($id);
        
        $this->validate($request, array(
          'quantity'=>'required|numeric'
        ));
        //update to DB
        $commodity->user_id = Auth::user()->id;
        $oldquantity = $commodity->quantity;
        $commodity->quantity = $request->quantity;
        $commodity->total = $request->total;
        $commodity->save();

        // STOCK PART
        //validation
        $stock = Stock::where('category_id', $commodity->category_id)->first();
        $this->validate($request, array(
            'quantity'=>'required|numeric'
        ));
        //update to DB
        $stock->user_id = Auth::user()->id;
        $stock->quantity = $stock->quantity - $oldquantity + $request->quantity;
        $stock->save();
        // STOCK PART

        Session::flash('success', 'Updated successfully!');
        //redirect
        return redirect()->route('commodities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
