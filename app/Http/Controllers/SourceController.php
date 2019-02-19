<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, Input, Redirect, Session;
use Auth;
use App\Source;

class SourceController extends Controller
{

    public function __construct() 
    {
      parent::__construct();
    }
    
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
                'total'=>'required|max:255',
                'newpaid'=>'required|max:255',
                // 'due'=>'required|max:255'
            ));
        } else {
            $this->validate($request, array(
                'name'=>'required|max:255|unique:sources,name',
                'total'=>'required|max:255',
                'newpaid'=>'required|max:255',
                // 'due'=>'required|max:255'
            ));
        }

        //update DB
        
        $source->name = $request->name;
        if(Auth::user()->roles->first()->name == 'superadmin') {
            $source->total = $request->total;
        }
        $source->paid = $source->paid + $request->newpaid;
        $source->due = $source->due - $request->newpaid;
        if($source->due < 0) {
            $source->due = 0;
        }
        // if total is 0 then all 0
        if($source->total == 0) {
            $source->paid = 0;
            $source->due = 0;
        }
        $source->save();

        Session::flash('success', 'Updated successfully!');
        //redirect
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        //
    }

    public function printSourcesNormal()
    {
        $sources = Source::all();

        return view('sources.normalprint')
                  ->withSources($sources);
    }
}
