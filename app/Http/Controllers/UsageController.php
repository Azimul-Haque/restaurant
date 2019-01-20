<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

use App\Category;
use App\Usage;

class UsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usages = Usage::orderBy('created_at', 'desc')->get();
        $categories = Category::all();

        return view('usages.index')
                    ->withUsages($usages)
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
        //
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
        //validation
        $this->validate($request, array(
          'quantity'=>'required|numeric',
          'rate'=>'required|numeric'
        ));
        //store to DB
        $usage = Usage::find($id);
        $usage->quantity = $request->quantity;
        $usage->rate = $request->rate;
        $usage->total = $request->quantity * $request->rate;
        $usage->save();

        Session::flash('success', 'Updated successfully!');
        //redirect
        return redirect()->route('usages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usage = Usage::find($id);
        $usage->delete();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->route('usages.index');
    }
}
