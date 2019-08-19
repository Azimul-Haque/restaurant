<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, Input, Redirect, Session;
use App\Category;
use App\Commodity;
use App\Stock;
use App\Source;
use Auth;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommodityController extends Controller
{
    public function __construct() 
    {
      parent::__construct();
    }
    public function index()
    {
        $commodities = Commodity::where('isdeleted', '=', 0)
                                ->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $sources = Source::all();

        return view('commodities.index')
                    ->withCommodities($commodities)
                    ->withCategories($categories)
                    ->withSources($sources);
    }

    public function getDeleted()
    {
        $commodities = Commodity::where('isdeleted', '=', 1)
                                ->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $sources = Source::all();

        return view('commodities.deleted')
                    ->withCommodities($commodities)
                    ->withCategories($categories)
                    ->withSources($sources);
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
          'source_id' => 'required|integer',
          'quantity'=>'required|numeric',
          'rate'=>'required|numeric',
          'total'=>'required|numeric' // the comma is ommited du to the next comments
          // 'paid'=>'required|numeric',
          // 'due'=>'required|numeric'
        ));
       
        //store to DB
        $commodity = new Commodity;
        $commodity->isdeleted = 0;
        $commodity->category_id = $request->category_id;
        $commodity->source_id = $request->source_id;
        $commodity->user_id = Auth::user()->id;
        $commodity->quantity = $request->quantity;
        $commodity->rate = $request->rate;
        $commodity->total = $request->total;
        // $commodity->paid = $request->paid;
        // $commodity->due = $request->total - $request->paid;
        $commodity->save();

        // update source TOTAL
        $source = Source::find($request->source_id);
        $source->total = $source->total + $request->total;
        $source->due = $source->due + $request->total;
        $source->save();
        // update source TOTAL

        // STOCK PART
        $category = Category::find($request->category_id);
        if($category->unit != 'N/A') {
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
            $stock->total = $stock->total + $request->total;
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
            $stock->total = $stock->total + $request->total;
          }
          
          $stock->save();
        }
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
          'category_id' => 'required|integer',
          'source_id' => 'required|integer',
          'quantity'=>'required|numeric',
          'rate'=>'required|numeric',
          'total'=>'required|numeric' // the comma is ommited du to the next comments
          // 'paid'=>'required|numeric',
          // 'due'=>'required|numeric'
        ));
        //update to DB
        $commodity->user_id = Auth::user()->id;
        $commodity->source_id = $request->source_id;
        $oldquantity = $commodity->quantity;
        $commodity->quantity = $request->quantity;
        $commodity->rate = $request->rate;

        // update source TOTAL before newTOTAL
        $source = Source::find($request->source_id);
        $source->total = $source->total - $commodity->total + $request->total;
        $source->save();
        // update source TOTAL before newTOTAL
        
        $commodity->total = $request->total;
        // $commodity->paid = $request->paid;
        // $commodity->due = $request->total - $request->paid;
        $commodity->save();

        // STOCK PART
        $category = Category::find($request->category_id);
        if($category->unit != 'N/A') {
          //validation
          $stock = Stock::where('category_id', $commodity->category_id)->first();
          $this->validate($request, array(
              'quantity'=>'required|numeric'
          ));
          //update to DB
          $stock->user_id = Auth::user()->id;
          $stock->quantity = $stock->quantity - $oldquantity + $request->quantity;
          $stock->save();
        }
        
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
        $commodity = Commodity::find($id);
        $commodity->isdeleted = 1;
        $commodity->save();
        
        // STOCK PART
        $stock = Stock::where('category_id', $commodity->category_id)->first();
        $stock->user_id = Auth::user()->id;
        $stock->quantity = $stock->quantity - $commodity->quantity;
        $stock->save();
        // STOCK PART

        // update source TOTAL before newTOTAL
        $source = Source::find($commodity->source_id);
        $total_non_zero = $source->total - $commodity->total;
        if($total_non_zero < 0) {
          $total_non_zero = 0;
        }
        $source->total = $total_non_zero;
        $source->save();
        // update source TOTAL before newTOTAL

        Session::flash('success', 'Deleted successfully!');
        //redirect
        return redirect()->route('commodities.index');
    }

    public function deleteAllCommodities(Request $request)
    {
        Commodity::truncate();

        Session::flash('success', 'Deleted successfully!');
        //redirect
        return redirect()->route('commodities.index');
    }
}
