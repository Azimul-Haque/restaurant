<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Smshistory;
use App\Smsbalance;
use App\Membership;
use SoapClient, Session;


class SmsController extends Controller
{
    public function index()
    {
        $balance = Smsbalance::find(1);
        $memberscount = Membership::all()->count();

        return view('sms.index')
                    ->withBalance($balance)
                    ->withMemberscount($memberscount);
    }

    public function sendBulk(Request $request)
    {
        $this->validate($request, array(
          'message' => 'required',
          'smscount'=>'required'
        ));

        $members = Membership::all();
        $balance = Smsbalance::find(1);

        $smssuccesscount = 0;
        $url = "http://66.45.237.70/api.php";
        $multiCurl = array();
        // data to be returned
        $result = array();
        // multi handle
        $mh = curl_multi_init();
        // sms data
        $smsdata = [];
        foreach ($members as $i => $member) {
            $mobile_number = 0;
            if(strlen($member->phone) == 11) {
                $mobile_number = '88'.$member->phone;
            } elseif(strlen($member->phone) > 11) {
                if (strpos($member->phone, '+') !== false) {
                    $mobile_number = substr($member->phone,0,1);
                }
            }
            if($mobile_number != 0) {
                $smsdata[$i] = array(
                    'username' => "01837409842",
                    'password' => "Bulk.Sms.Bd.123",
                    'number' => $mobile_number,
                    'message' => $request->message,
                    'membership_id' => $member->id,
                    'smscount' => $request->smscount
                );

                $multiCurl[$i] = curl_init(); // Initialize cURL
                curl_setopt($multiCurl[$i], CURLOPT_URL, $url);
                curl_setopt($multiCurl[$i], CURLOPT_HEADER, 0);
                curl_setopt($multiCurl[$i], CURLOPT_POSTFIELDS, http_build_query($smsdata[$i]));
                curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER, 1);
                curl_multi_add_handle($mh, $multiCurl[$i]);
            }
        }

        if($balance->balance > 1) {
            $index=null;
            do {
              curl_multi_exec($mh, $index);
            } while($index > 0);
            // get content and remove handles
            foreach($multiCurl as $k => $ch) {
              $result[$k] = curl_multi_getcontent($ch);
              curl_multi_remove_handle($mh, $ch);
              $p = explode("|",$result[$k]);
              $sendstatus = $p[0];
              // dd($sendstatus);
              if($sendstatus == 1101) {
                  $smssuccesscount++;
              }
            }
            foreach ($smsdata as $smshistory) {
                $history = new Smshistory;
                $history->membership_id = $smshistory['membership_id'];
                $history->smscount = $smshistory['smscount'];
                $history->save();
            }
        } else {
            Session::flash('warning', 'Insufficient balance! Please recharge!');
            return redirect()->route('sms.index');
        }
        
        // close
        curl_multi_close($mh);

        $newbalance = $balance->balance - ($smssuccesscount * (int)$request->smscount);
        if($newbalance < 0) {
            $newbalance = 0;
        }
        $balance->balance = $newbalance;
        $balance->save();

        if($smssuccesscount == 0) {
            Session::flash('warning', 'কোন সমস্যা হয়েছে। ডেভেলপারের সাথে যোগাযোগ করুন!');
        } else {
            Session::flash('success', $smssuccesscount.' টি SMS সফলভাবে প্রেরণ করা হয়েছে!');
        }
        return redirect()->route('sms.index');
    }

    public function getAdmin() {
        $actualbalance = number_format((float) file_get_contents('http://66.45.237.70/balancechk.php?username=01837409842&password=Bulk.Sms.Bd.123'), 2, '.', '');
        $qikbalance = Smsbalance::find(1);

        return view('sms.admin')
                    ->withActualbalance($actualbalance)
                    ->withQikbalance($qikbalance);
    }

    public function addSms(Request $request) {
        $this->validate($request, array(
          'smsamount'=>'required'
        ));

        $balance = Smsbalance::find(1);
        $balance->balance = $balance->balance + $request->smsamount;
        $balance->save();

        return redirect()->route('sms.admin');
    }

    // public function sendsms()
    // {
    //     try{
    //         $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
    //         $paramArray = array(
    //             'userName' => "01751398392",
    //             'userPassword' => "OnnoRokomRocks.1992",
    //         );
    //         $value = $soapClient->__call("GetBalance", array($paramArray));
    //         $netBalance = floor($value->GetBalanceResult/0.60);
    //         echo 'Balance: '.$netBalance.'<br/>';
    //     } catch (Exception $e) {
    //         echo $e->getMessage();
    //     }

    //     try{
    //         $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
    //         $paramArray = array(
    //         'userName' => "",
    //         'userPassword' => "",
    //         'mobileNumber' => "01751398392",
    //         'smsText' => "This is a SMS. ইহা একটি পরীক্ষামূলক বার্তা।",
    //         'type' => "TEXT",
    //         'maskName' => '',
    //         'campaignName' => '',
    //         );
    //         $value = $soapClient->__call("OneToOne", array($paramArray));
    //         echo $value->OneToOneResult;
    //     } catch (Exception $e) {
    //         echo $e->getMessage();
    //     }
    // }
}