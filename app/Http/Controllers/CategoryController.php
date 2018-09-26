<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Session;

use App\Category;
use App\Source;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $sources = Source::all();

        return view('categories.index')
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
        //
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
