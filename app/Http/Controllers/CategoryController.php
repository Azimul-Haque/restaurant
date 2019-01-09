<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Session;

use App\Category;
use App\Commodity;
use App\Source;

use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $sources = Source::all();
        $commodities = DB::table('commodities')
                        ->select('source_id', DB::raw('SUM(total) as totalsource'), DB::raw('SUM(paid) as paidsource'), DB::raw('SUM(due) as duesource'))
                        ->groupBy('source_id')
                        ->get();
                        //dd($commodities);

        return view('categories.index')
                  ->withCategories($categories)
                  ->withSources($sources)
                  ->withCommodities($commodities);
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

    public function getCategoryUnitAPI($id)
    {
        try {
          $categoryunit = Category::find($id);
          return $categoryunit->unit;
        }
        catch (\Exception $e) {
          return 'N/A';
        }
    }

    
    public function store(Request $request)
    {
        //validation
        $this->validate($request, array(
            'name'=>'required|max:255|unique:categories,name',
            'unit'=>'required|max:255'
        ));

        //store to DB
        $category = new Category;
        $category->name = $request->name;
        $category->unit = $request->unit;
        $category->save();

        Session::flash('success', 'A new Category has been created successfully!');
        //redirect
        return redirect()->route('categories.index');
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
        $category = Category::find($id);
        //validation
        if($category->name == $request->name) {
            $this->validate($request, array(
                'name'=>'required|max:255',
                'unit'=>'required|max:255'
            ));
        } else {
            $this->validate($request, array(
                'name'=>'required|max:255|unique:categories,name',
                'unit'=>'required|max:255'
            ));
        }
        
        //update DB
        $category->name = $request->name;
        $category->unit = $request->unit;
        $category->save();

        Session::flash('success', 'Updated successfully!');
        //redirect
        return redirect()->route('categories.index');
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
