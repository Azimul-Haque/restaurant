<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, Input, Redirect, Session;

use App\Source;

class SourceController extends Controller
{

    public function store(Request $request)
    {
        //validation
        $this->validate($request, array(
            'name'=>'required|max:255|unique:sources,name',
        ));

        //store to DB
        $source = new Source;
        $source->name = $request->name;
        $source->save();

        Session::flash('success', 'A new Source has been created successfully!');
        //redirect
        return redirect()->route('categories.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $source = Source::find($id);
        //validation
        if($source->name == $request->name) {
            $this->validate($request, array(
                'name'=>'required|max:255',
            ));
        } else {
            $this->validate($request, array(
                'name'=>'required|max:255|unique:sources,name',
            ));
        }

        //update DB
        
        $source->name = $request->name;
        $source->save();

        Session::flash('success', 'Updated successfully!');
        //redirect
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        //
    }
}
