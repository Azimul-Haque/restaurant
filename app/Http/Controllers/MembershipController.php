<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Membership;
use App\Smshistory;
use App\Smsbalance;
use Session;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function getIndex() {

      $memberships = Membership::where('isdeleted', '=', 0)
                               ->orderBy('id', 'desc')->get();
      
      return view('membership.index')
                 ->withMemberships($memberships);
    }

    public function store(Request $request) {
        //validation
        $this->validate($request, array(
          'name' => 'required|max:255',
          'phone' => 'required|max:11|unique:memberships,phone',
          'point'=>'required|numeric',
          'type'=>'required'
        ));
       
        //store to DB
        $member = new Membership;
        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->point = $request->point;
        $member->type = $request->type;
        $member->awarded = 0;
        $member->isdeleted = 0;
        $member->save();

        $balance = Smsbalance::find(1);

        // send sms
        $mobile_number = 0;
        if(strlen($request->phone) == 11) {
            $mobile_number = '88'.$request->phone;
        } elseif(strlen($request->phone) > 11) {
            if (strpos($request->phone, '+') !== false) {
                $mobile_number = substr($request->phone,0,1);
            }
        }

        $url = "http://66.45.237.70/api.php";
        $number = $mobile_number;
        $text = 'Dear ' . $request->name . ', thanks for feeling the food at Queen Island Kitchen! Please come again! Visit: http://queenislandkitchen.com';
        $data= array(
            'username'=>"01878036200",
            'password'=>"Bulk.Sms.Bd.123",
            'number'=>"$number",
            'message'=>"$text"
        );

        // initialize send status
        $sendstatus = 0;
        if($balance->balance > 1) {
            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];
        } else {
            Session::flash('warning', 'Insufficient balance! Could not send Welcome SMS!');
        }
        // send sms

        if($sendstatus == 1101) {
            $newbalance = $balance->balance - 1;
            if($newbalance < 0) {
                $newbalance = 0;
            }
            $balance->balance = $newbalance;
            $balance->save();

            $history = new Smshistory;
            $history->membership_id = $member->id;
            $history->smscount = 1;
            $history->save();
            
            Session::flash('success', 'Welcome SMS sent successfully!');
        } else {
            Session::flash('warning', 'Welcome SMS sending failed');
        }

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
            'newpoint'=>'required|numeric',
            'type'=>'required'
          ));
        } else {
          $this->validate($request, array(
            'name' => 'required|max:255',
            'phone' => 'required|max:11|unique:memberships,phone',
            'newpoint'=>'required|numeric',
            'type'=>'required'
          ));  
        }
       
        //update DB
        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->point = $member->point + $request->newpoint;
        $member->type = $request->type;
        $member->save();

        $balance = Smsbalance::find(1);

        // send sms
        $mobile_number = 0;
        if(strlen($request->phone) == 11) {
            $mobile_number = '88'.$request->phone;
        } elseif(strlen($request->phone) > 11) {
            if (strpos($request->phone, '+') !== false) {
                $mobile_number = substr($request->phone,0,1);
            }
        }

        $url = "http://66.45.237.70/api.php";
        $number = $mobile_number;
        $text = 'Dear ' . $request->name . ', ' . $request->newpoint . ' points have been added to your account. Total points: ' . $member->point .  '. Please come again! Visit: http://queenislandkitchen.com';
        $data= array(
            'username'=>"01878036200",
            'password'=>"Bulk.Sms.Bd.123",
            'number'=>"$number",
            'message'=>"$text"
        );

        // initialize send status
        $sendstatus = 0;
        if($balance->balance > 1) {
            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];
        } else {
            Session::flash('warning', 'Insufficient balance! Could not send Point SMS!');
        }
        // send sms

        if($sendstatus == 1101) {
            $newbalance = $balance->balance - 1;
            if($newbalance < 0) {
                $newbalance = 0;
            }
            $balance->balance = $newbalance;
            $balance->save();

            $history = new Smshistory;
            $history->membership_id = $member->id;
            $history->smscount = 1;
            $history->save();
            
            Session::flash('success', 'Point SMS sent successfully!');
        } else {
            Session::flash('warning', 'Point SMS sending failed');
        }

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
        $member->isdeleted = 1;
        $member->save();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->route('membership.index');
    }

    public function sendSingleSMS($id, Request $request)
    {
        $this->validate($request, array(
          'phone' => 'required|max:11',
          'message' => 'required',
          'membership_id'=>'required',
          'smscount'=>'required'
        ));

        $member = Membership::find($id);
        $balance = Smsbalance::find(1);

        // send sms
        $mobile_number = 0;
        if(strlen($request->phone) == 11) {
            $mobile_number = '88'.$request->phone;
        } elseif(strlen($request->phone) > 11) {
            if (strpos($request->phone, '+') !== false) {
                $mobile_number = substr($request->phone,0,1);
            }
        }

        $url = "http://66.45.237.70/api.php";
        $number = $mobile_number;
        $text = $request->message;
        $data= array(
        'username'=>"01878036200",
        'password'=>"Bulk.Sms.Bd.123",
        'number'=>"$number",
        'message'=>"$text"
        );

        if($balance->balance > 1) {
            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];
        } else {
            Session::flash('warning', 'Insufficient balance! Please recharge!');
            return redirect()->route('membership.index');
        }
        // send sms

        if($sendstatus == 1101) {
            $newbalance = $balance->balance - (int)$request->smscount;
            if($newbalance < 0) {
                $newbalance = 0;
            }
            $balance->balance = $newbalance;
            $balance->save();

            $history = new Smshistory;
            $history->membership_id = $request->membership_id;
            $history->smscount = $request->smscount;
            $history->save();
            
            Session::flash('success', 'SMS sent successfully!');
            return redirect()->route('membership.index');
        } else {
            Session::flash('warning', 'SMS sending failed, try again!');
            return redirect()->route('membership.index');
        }
    }
}
