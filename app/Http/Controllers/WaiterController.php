<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Session;

use App\Waiter;

class WaiterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $waiters = Waiter::all();
        return view('waiters.index')->withWaiters($waiters);
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
        //validation
        $this->validate($request, array(
          'name' => 'required|max:255'
        ));

        //store to DB
        $waiter = new Waiter;
        $waiter->name = $request->name;
        $waiter->save();

        Session::flash('success', 'A new Waiter has been created successfully!');
        return redirect()->route('waiters.index');
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
          'newpoint' => 'required|max:255'
        ));

        $waiter = Waiter::find($id);

        //update DB
        $waiter->order = $waiter->order + 1;
        $waiter->point = $waiter->point + $request->newpoint;
        $waiter->save();

        Session::flash('success', 'Updated successfully!');
        return redirect()->route('waiters.index');
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
