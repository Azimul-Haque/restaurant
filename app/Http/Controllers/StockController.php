<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, Input, Redirect, Session;
use App\Category;
use App\Stock;
use App\Usage;
use Auth;


class StockController extends Controller
{
    public function __construct() 
    {
      parent::__construct();
    }
    
    public function index()
    {
        $categories = Category::where('unit', '!=', 'N/A')
                              ->orderBy('name', 'asc')
                              ->get()->sortBy('name', SORT_NATURAL, false); // false for ascending

        $category_id = array();
        foreach ($categories as $category) {
          $category_id[] = $category->id;
        }
        $stocks = Stock::whereIn('category_id', $category_id)->get();

        $newstocks = [];
        foreach($categories as $category) {
            foreach($stocks as $stock) {
                if($category->name == $stock->category->name) {
                    array_push($newstocks, $stock);
                }
            }
        }

        return view('stocks.index')
                    ->withStocks($newstocks)
                    ->withCategories($categories);
    }

    public function getCategoryMaxAPI($category_id)
    {
        try {
          $categorymax = Stock::where('category_id', $category_id)->first();
          return $categorymax->quantity;
        }
        catch (\Exception $e) {
          return 'N/A';
        }
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
        try {
          $stock = Stock::where('category_id', $request->category_id)->first();

          $this->validate($request, array(
            'category_id' => 'required|integer',
            'quantity'=>'required|numeric|min:0'
          ));
          //update to DB

          // get the average Rate
          $average_rate = number_format((float)($stock->total / $stock->quantity), 2, '.', '');
          $stock->quantity = $stock->quantity - $request->quantity;
          
          $stock->total = $stock->total - ($request->quantity * $average_rate);
          $stock->save();

          // USAGE PART
          //store to DB
          $usage = new Usage;
          $usage->category_id = $request->category_id;
          $usage->user_id = Auth::user()->id;
          $usage->quantity = $request->quantity;
          $usage->rate = $average_rate;
          $usage->total = $request->quantity * $average_rate;
          $usage->save();
          // USAGE PART

          Session::flash('success', 'Updated successfully!');
          //redirect
          return redirect()->route('stocks.index');
        }
        catch (\Exception $e) {
          Session::flash('warning', 'এই আইটেমটি এখনও দাখিল করা হয়নি');
          //redirect
          return redirect()->route('stocks.index');
        }

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
        $stock = Stock::find($id);
        
        $this->validate($request, array(
          'quantity'=>'required|numeric',
          'total'=>'required|numeric'
        ));
        //update to DB
        $stock->user_id = Auth::user()->id;
        $stock->quantity = $request->quantity;
        $stock->total = $request->total;
        $stock->save();

        Session::flash('success', 'Updated successfully!');
        //redirect
        return redirect()->route('stocks.index');
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
