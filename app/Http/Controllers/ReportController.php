<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Commodity;
use App\Source;
use App\Stock;
use App\Usage;
use App\Qikstock;
use App\Qikusage;
use App\Receipt;
use App\Membership;
use App\Smshistory;
use App\Stuff;
use App\Stuffpayment;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function __construct() 
    {
      parent::__construct();
    }
    
    public function getIndex()
    {
        $sources = Source::all();
        $stuffs = Stuff::all();
        return view('reports.index')
                   ->withSources($sources)
                   ->withStuffs($stuffs);
    }

    public function getPDFCommodity(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));
        $commodities = Commodity::whereBetween('created_at', [$from, $to])
                        ->orderBy('created_at', 'desc')
                        ->where('isdeleted', '=', 0)
                        ->get();
        $commodity_total = DB::table('commodities')
                        ->select(DB::raw('SUM(total) as totaltotal'), DB::raw('SUM(paid) as paidtotal'), DB::raw('SUM(due) as duetotal'))
                        ->whereBetween('created_at', [$from, $to])
                        ->where('isdeleted', '=', 0)
                        ->first();

        $pdf = PDF::loadView('reports.pdf.commodity', ['commodities' => $commodities], ['data' => [$request->from, $request->to, $commodity_total->totaltotal, $commodity_total->paidtotal, $commodity_total->duetotal]]);
        $fileName = 'Commodity_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFStock(Request $request)
    {
        //validation
        $this->validate($request, array(
          'stock_report_type' => 'required'
        ));

        $stocks = null;
        $message = '';
        if($request->stock_report_type == 'all') {
            $stocks = Stock::with(['category' => function($query) {
                                $query->orderBy('name', 'asc');
                             }])->get();
            $message = 'শেষ হয়ে যাওয়া সামগ্রীসহ';
        } elseif ($request->stock_report_type == 'onlyexisting') {
            $stocks = Stock::where('quantity', '>', 0)
                           ->with(['category' => function($query) {
                                $query->orderBy('name', 'asc');
                             }])->get();
            $message = 'শুধুমাত্র বিদ্যমান সামগ্রীগুলো';
        }

        $categories = Category::orderBy('name', 'asc')->get();

        $newstocks = [];
        foreach($categories as $category) {
            foreach($stocks as $stock) {
                if($category->name == $stock->category->name) {
                    array_push($newstocks, $stock);
                }
            }
        }

        $pdf = PDF::loadView('reports.pdf.stock', ['stocks' => $newstocks], ['message' => $message]);
        $fileName = $message .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFQIKStock(Request $request)
    {
        //validation
        $this->validate($request, array(
          'stock_report_type' => 'required'
        ));

        $stocks = null;
        $message = '';
        if($request->stock_report_type == 'all') {
            $stocks = Qikstock::orderBy('name', 'asc')->get();
            $message = 'শেষ হয়ে যাওয়া সামগ্রীসহ';
        } elseif ($request->stock_report_type == 'onlyexisting') {
            $stocks = Qikstock::where('quantity', '>', 0)
                              ->orderBy('name', 'asc')->get();
            $message = 'শুধুমাত্র বিদ্যমান সামগ্রীগুলো';
        }

        $pdf = PDF::loadView('reports.pdf.qikstock', ['stocks' => $stocks], ['message' => $message]);
        $fileName = $message .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFSource(Request $request)
    {
        //validation
        $this->validate($request, array(
          'source_id' => 'required',
          'from' => 'required',
          'to' => 'required'
        ));
        
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));

        $source = Source::find($request->source_id);

        $sources = Commodity::whereBetween('created_at', [$from, $to])
                                ->where('source_id', $request->source_id)
                                ->orderBy('created_at', 'desc')
                                ->where('isdeleted', '=', 0)
                                ->get();
        
        $source_total = DB::table('commodities')
                        ->select('source_id', DB::raw('SUM(total) as totalsource'), DB::raw('SUM(paid) as paidsource'), DB::raw('SUM(due) as duesource'))
                        ->whereBetween('created_at', [$from, $to])
                        ->where('source_id', $request->source_id)
                        ->where('isdeleted', '=', 0)
                        ->first();

        $pdf = PDF::loadView('reports.pdf.source', ['sources' => $sources], ['source_data' => [$source->name, $source_total->totalsource, $source_total->paidsource, $source_total->duesource]]);
        $fileName = $source->name .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPOSSource(Request $request)
    {
        //validation
        $this->validate($request, array(
          'source_id' => 'required',
          'from' => 'required',
          'to' => 'required'
        ));
        
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));

        $source = Source::find($request->source_id);

        $sources = Commodity::whereBetween('created_at', [$from, $to])
                                ->where('source_id', $request->source_id)
                                ->orderBy('created_at', 'desc')
                                ->where('isdeleted', '=', 0)
                                ->get();
        
        $source_total = DB::table('commodities')
                        ->select('source_id', DB::raw('SUM(total) as totalsource'), DB::raw('SUM(paid) as paidsource'), DB::raw('SUM(due) as duesource'))
                        ->whereBetween('created_at', [$from, $to])
                        ->where('source_id', $request->source_id)
                        ->where('isdeleted', '=', 0)
                        ->first();

        return view('reports.pos.source')
                   ->withSource($source)
                   ->withSources($sources)
                   ->withSourcetotal($source_total);
    }

    public function getPDFUsage(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));
        $usages = Usage::whereBetween('created_at', [$from, $to])->get();
        
        $categories = Category::orderBy('name', 'asc')->get();
        $newusages = [];
        foreach($categories as $category) {
            foreach($usages as $usage) {
                if($category->name == $usage->category->name) {
                    array_push($newusages, $usage);
                }
            }
        }
        $pdf = PDF::loadView('reports.pdf.usage', ['usages' => $newusages], ['date' => [$request->from, $request->to]]);
        $fileName = 'Usage_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFQIKUsage(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));
        $usages = Qikusage::whereBetween('created_at', [$from, $to])->get();
        
        $stocks = Qikstock::orderBy('name', 'asc')->get();
        $newusages = [];
        foreach($stocks as $stock) {
            foreach($usages as $usage) {
                if($stock->name == $usage->qikstock->name) {
                    array_push($newusages, $usage);
                }
            }
        }
        $pdf = PDF::loadView('reports.pdf.qikusage', ['usages' => $newusages], ['date' => [$request->from, $request->to]]);
        $fileName = 'QIK_Usage_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFIncome(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));

        DB::statement('SET SESSION group_concat_max_len = 1000000');
        $incomes = DB::table('receipts')
                        ->select('created_at', DB::raw('SUM(discounted_total) as totalsale'))
                        ->where('isdeleted', '=', 0)
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->whereBetween('created_at', [$from, $to])
                        ->orderBy('created_at', 'asc')
                        ->get();
        $incomes_total = DB::table('receipts')
                        ->select(DB::raw('SUM(discounted_total) as totalgross'))
                        ->where('isdeleted', '=', 0)
                        ->whereBetween('created_at', [$from, $to])
                        ->first();
        $pdf = PDF::loadView('reports.pdf.income', ['incomes' => $incomes], ['data' => [$request->from, $request->to, $incomes_total->totalgross]]);
        $fileName = 'Income_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFExpense(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));

        DB::statement('SET SESSION group_concat_max_len = 1000000');
        $expenses = DB::table('usages')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        // ->where('isdeleted', '=', 0)
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->whereBetween('created_at', [$from, $to])
                        ->orderBy('created_at', 'asc')
                        ->get();
        $expenses_total = DB::table('usages')
                        ->select(DB::raw('SUM(total) as totalgross'))
                        // ->where('isdeleted', '=', 0)
                        ->whereBetween('created_at', [$from, $to])
                        ->first();
        $pdf = PDF::loadView('reports.pdf.expense', ['expenses' => $expenses], ['data' => [$request->from, $request->to, $expenses_total->totalgross]]);
        $fileName = 'Expenditure_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFMember(Request $request)
    {
        //validation
        $this->validate($request, array(
          'members_report_type' => 'required'
        ));
        $members = null;
        $message = '';
        if($request->members_report_type == 'onlyawarded') {
            $members = Membership::where('awarded', '>', 0)
                                 ->where('name', '!=','Direct_Contact')
                                 ->orderBy('awarded', 'desc')->get();
            $message = 'ন্যূনতম একবার পুরষ্কারপ্রাপ্ত';
        } elseif ($request->members_report_type == 'neverawarded') {
            $members = Membership::where('awarded', 0)
                                 ->where('name', '!=','Direct_Contact')
                                 ->orderBy('id', 'desc')->get();
            $message = 'একবারও পুরষ্কারপ্রাপ্ত নন';
        } elseif ($request->members_report_type == 'all') {
            $members = Membership::where('name', '!=','Direct_Contact')
                                 ->orderBy('awarded', 'desc')->get();
            $message = 'পুরষ্কারপ্রাপ্ত এবং পুরষ্কারপ্রাপ্ত নন সবাই';
        }
        // /dd($members);

        $pdf = PDF::loadView('reports.pdf.member', ['members' => $members], ['message' => $message]);
        $fileName = $message . '.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFItemsDateWise(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));
        
        $sales = DB::table('receipts')
                        ->select(DB::raw('SUM(discounted_total) as totalsale'))
                        ->whereBetween('created_at', [$from, $to])
                        ->where('isdeleted', '=', 0)
                        ->first();
        DB::statement('SET SESSION group_concat_max_len = 10000000');
        $items = DB::table('receipts')
                     ->select(DB::raw('group_concat(receiptdata) as receiptdata'))
                     ->whereBetween('created_at', [$from, $to])
                     ->where('isdeleted', '=', 0)
                     ->first();

        $items_array = '[' .$items->receiptdata . ']';
        $decoded_items_array = json_decode($items_array);
        $merged = [];
        for($i = 0; $i < count($decoded_items_array); $i++) {
          $merged2 = json_decode(json_encode($decoded_items_array[$i]->items), true);
          $merged = array_merge($merged,$merged2);
        }

        $mergedReceiptData = [];
        foreach ($merged as $values) {
            $key = $values['name'];

            if(array_key_exists($key, $mergedReceiptData)) {
                $mergedReceiptData[$key][0]['qty'] = $mergedReceiptData[$key][0]['qty'] + $values['qty'];
                $mergedReceiptData[$key][0]['price'] = $mergedReceiptData[$key][0]['price'] + $values['price'];
            } else {
                $mergedReceiptData[$key][] = $values;
            }
        }
  
        array_multisort(array_keys($mergedReceiptData), SORT_NATURAL, $mergedReceiptData);
        // dd($mergedReceiptData);
        $grossitems =$mergedReceiptData;
        
        $pdf = PDF::loadView('reports.pdf.itemsdatewise', ['grossitems' => $grossitems], ['data' => [$request->from, $request->to, $sales->totalsale]]);
        $fileName = 'Item_Date_Wise_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFSMSHistory(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));
        
        $smshistory = Smshistory::whereBetween('created_at', [$from, $to])->get();

        $totalsms = DB::table('smshistories')
                        ->select(DB::raw('SUM(smscount) as totalsms'))
                        ->whereBetween('created_at', [$from, $to])
                        ->first();

        $pdf = PDF::loadView('reports.pdf.smshistory', ['smshistory' => $smshistory], ['date' => [$request->from, $request->to, (int)$totalsms->totalsms]]);
        $fileName = 'SMS_History_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFStuffsPayment(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required'
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));
        $stuffpayments = Stuffpayment::whereBetween('created_at', [$from, $to])->get();
        
        $totalpayment = DB::table('stuffpayments')
                        ->select(DB::raw('SUM(amount) as totalpayment'))
                        ->whereBetween('created_at', [$from, $to])
                        ->first();

        $stuffs = Stuff::orderBy('name', 'asc')->get();
        $newstuffpayments = [];
        foreach($stuffs as $stuff) {
            foreach($stuffpayments as $stuffpayment) {
                if($stuff->name == $stuffpayment->stuff->name) {
                    array_push($newstuffpayments, $stuffpayment);
                }
            }
        }
        $pdf = PDF::loadView('reports.pdf.staffspayment', ['stuffpayments' => $newstuffpayments], ['date' => [$request->from, $request->to, $totalpayment->totalpayment]]);
        $fileName = 'Stuffs_Payments_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFSingleStuffPayment(Request $request)
    {
        //validation
        $this->validate($request, array(
          'stuff_id' => 'required',
          'from'     => 'required',
          'to'       => 'required'
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));

        $stuffpayments = Stuffpayment::where('stuff_id', $request->stuff_id)
                                     ->whereBetween('created_at', [$from, $to])->get();
        
        $totalpayment = DB::table('stuffpayments')
                        ->where('stuff_id', $request->stuff_id)
                        ->select(DB::raw('SUM(amount) as totalpayment'))
                        ->whereBetween('created_at', [$from, $to])
                        ->first();

        $stuff = Stuff::find($request->stuff_id);

        $pdf = PDF::loadView('reports.pdf.singlestuff', ['stuffpayments' => $stuffpayments], ['date' => [$request->from, $request->to, $totalpayment->totalpayment, $stuff->name]]);
        $fileName = 'Payment_Report_of_'. $stuff->name . '_' . date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->download($fileName);
    }

    public function getPDFAllSource()
    {
        $sources = Source::all();

        $pdf = PDF::loadView('reports.pdf.allsources', ['sources' => $sources]);
        $fileName = 'Sources_Report.pdf';
        return $pdf->download($fileName);
    }
}
