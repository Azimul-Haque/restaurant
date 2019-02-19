<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator, Input, Redirect, Session;
use Auth;

use App\Receipt;
use App\Commodity;
use App\Usage;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function __construct() 
    {
      parent::__construct();
    }
    
    public function index() {
        $thismonthscollection = DB::table('receipts')
                        ->select('created_at', DB::raw('SUM(discounted_total) as totalprice'))
                        ->where('isdeleted', '=', 0)
                        ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->orderBy('created_at', 'DESC')
                        ->first();
                        //dd($thismonthscollection);
        $lastsevendayscollection = DB::table('receipts')
                        ->select('created_at', DB::raw('SUM(discounted_total) as totalprice'))
                        ->where('isdeleted', '=', 0)
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->orderBy('created_at', 'DESC')
                        ->take(7)
                        ->get();
        
        $datesforchartc = [];
        foreach ($lastsevendayscollection as $key => $days) {
            $datesforchartc[] = date_format(date_create($days->created_at), "M d");
        }
        $datesforchartc = json_encode(array_reverse($datesforchartc));

        $totalsforchartc = [];
        foreach ($lastsevendayscollection as $key => $days) {
            $totalsforchartc[] = $days->totalprice;
        }
        $totalsforchartc = json_encode(array_reverse($totalsforchartc));

        $thismonthsexpense = DB::table('usages')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->orderBy('created_at', 'DESC')
                        ->first();
        $lastsevendaysexpense = DB::table('usages')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->orderBy('created_at', 'DESC')
                        ->take(7)
                        ->get();
        
        $datesforcharte = [];
        foreach ($lastsevendaysexpense as $key => $days) {
            $datesforcharte[] = date_format(date_create($days->created_at), "M d");
        }
        $datesforcharte = json_encode(array_reverse($datesforcharte));

        $totalsforcharte = [];
        foreach ($lastsevendaysexpense as $key => $days) {
            $totalsforcharte[] = $days->totalprice;
        }
        $totalsforcharte = json_encode(array_reverse($totalsforcharte));


        return view('dashboard.dashboard')
                  ->withThismonthscollection($thismonthscollection)
                  ->withDatesforchartc($datesforchartc)
                  ->withTotalsforchartc($totalsforchartc)
                  ->withThismonthsexpense($thismonthsexpense)
                  ->withDatesforcharte($datesforcharte)
                  ->withTotalsforcharte($totalsforcharte);
    }

    public function getExpenditure() {
        $todaysexpense = DB::table('usages')
                        ->select(DB::raw('SUM(total) as totalprice'))
                        ->whereDate('created_at', '>=', Carbon::today())
                        // ->where('isdeleted', '=', 0)
                        ->first();

        $thisyearsexpense = DB::table('usages')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), "=", Carbon::now()->format('Y'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        // ->where('isdeleted', '=', 0)
                        ->orderBy('created_at', 'DESC')
                        ->get();

        $thismonthsexpense = DB::table('usages')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        // ->where('isdeleted', '=', 0)
                        ->orderBy('created_at', 'DESC')
                        ->get();

        $lastsevendaysexpense = DB::table('usages')
                        ->select('created_at', DB::raw('SUM(total) as totalprice'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        // ->where('isdeleted', '=', 0)
                        ->orderBy('created_at', 'DESC')
                        ->take(7)
                        ->get();
        
        $datesforchart = [];
        foreach ($lastsevendaysexpense as $key => $days) {
            $datesforchart[] = date_format(date_create($days->created_at), "M d");
        }
        $datesforchart = json_encode(array_reverse($datesforchart));

        $totalsforchart = [];
        foreach ($lastsevendaysexpense as $key => $days) {
            $totalsforchart[] = $days->totalprice;
        }
        $totalsforchart = json_encode(array_reverse($totalsforchart));

        return view('commodities.expenditure')
                    ->withTodaysexpense($todaysexpense)
                    ->withThisyearsexpense($thisyearsexpense)
                    ->withThismonthsexpense($thismonthsexpense)
                    ->withDatesforchart($datesforchart)
                    ->withTotalsforchart($totalsforchart);
    }
}
