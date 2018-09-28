<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Receipt;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Receipt::orderBy('created_at','DESC')->paginate(8);
        return view('receipts.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 8);
    }

    public function getSales()
    {
        $sales = DB::table('receipts')
                        ->select('created_at', DB::raw('SUM(total) as totalsale'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->orderBy('created_at', 'DESC')
                        ->get();
                        //dd($sales);
        DB::statement('SET SESSION group_concat_max_len = 1000000');
        $details = DB::table('receipts')
                        ->select('created_at', DB::raw('group_concat(receiptdata) as receiptdata'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->orderBy('created_at', 'DESC')
                        ->get();
                        //dd($details);
        return view('receipts.sales',compact('data'))
            ->withSales($sales)
            ->withDetails($details);
    }

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
        // it will be performed from an third party api...
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

    // accounts
    public function getIncome() {
        $todayscollection = DB::table('receipts')
                        ->select(DB::raw('SUM(total) as totalprice'))
                        ->whereDate('created_at', '>=', Carbon::today())
                        ->first();

        $thisyearscollection = DB::table('receipts')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), "=", Carbon::now()->format('Y'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->orderBy('created_at', 'DESC')
                        ->get();
                        // dd($thisyearscollection);

        $thismonthscollection = DB::table('receipts')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->orderBy('created_at', 'DESC')
                        ->get();
                        // dd($thismonthscollection);
                        // to get month omit %d & get to first, to take last 7 use ->take(7)

        $lastsevendayscollection = DB::table('receipts')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->orderBy('created_at', 'DESC')
                        ->take(7)
                        ->get();
        
        $datesforchart = [];
        foreach ($lastsevendayscollection as $key => $days) {
            $datesforchart[] = date_format(date_create($days->created_at), "M d");
        }
        $datesforchart = json_encode(array_reverse($datesforchart));

        $totalsforchart = [];
        foreach ($lastsevendayscollection as $key => $days) {
            $totalsforchart[] = $days->totalprice;
        }
        $totalsforchart = json_encode(array_reverse($totalsforchart));
        // dd($totalsforchart);

        return view('receipts.income')
                    ->withTodayscollection($todayscollection)
                    ->withThisyearscollection($thisyearscollection)
                    ->withThismonthscollection($thismonthscollection)
                    ->withDatesforchart($datesforchart)
                    ->withTotalsforchart($totalsforchart);
    }
}
