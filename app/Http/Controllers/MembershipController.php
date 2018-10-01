<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Membership;
use Session;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function getIndex() {

      $memberships = Membership::orderBy('id', 'desc')->get();
      
      return view('membership.index')
                 ->withMemberships($memberships);
    }

    public function store(Request $request) {
        //validation
        $this->validate($request, array(
          'name' => 'required|max:255',
          'phone' => 'required|max:11|unique:memberships,phone',
          'point'=>'required|numeric'
        ));
       
        //store to DB
        $member = new Membership;
        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->point = $request->point;
        $member->awarded = 0;
        $member->save();

        Session::flash('success', 'A new Member has been created successfully!');
        return redirect()->route('membership.index');
    }

    public function update(Request $request, $id) {
        
        $member = Membership::find($id);
        //validation
        if($member->phone == $request->phone) {
          $this->validate($request, array(
            'name' => 'required|max:255',
            'phone' => 'required|max:11',
            'newpoint'=>'required|numeric'
          ));
        } else {
          $this->validate($request, array(
            'name' => 'required|max:255',
            'phone' => 'required|max:11|unique:memberships,phone',
            'newpoint'=>'required|numeric'
          ));  
        }
       
        //update DB
        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->point = $member->point + $request->newpoint;
        $member->save();

        Session::flash('success', 'Updated successfully!');
        return redirect()->route('membership.index');
    }

    public function award($id)
    {
        $member = Membership::find($id);
        $member->awarded = $member->awarded + 1;
        $member->point = 0;
        $member->save();

        Session::flash('success', 'Updated successfully!');
        return redirect()->route('membership.index');
    }

    public function destroy($id)
    {
        $member = Membership::find($id);
        $member->delete();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->route('membership.index');
    }
}
