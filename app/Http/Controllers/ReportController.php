<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Commodity;
use App\Stock;
use App\Source;
use App\Usage;
use App\Receipt;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function getIndex()
    {
        $sources = Source::all();
        return view('reports.index')
                   ->withSources($sources);
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
                        ->get();
        $commodity_total = DB::table('commodities')
                        ->select(DB::raw('SUM(total) as totaltotal'), DB::raw('SUM(paid) as paidtotal'), DB::raw('SUM(due) as duetotal'))
                        ->whereBetween('created_at', [$from, $to])
                        ->first();

        $pdf = PDF::loadView('reports.pdf.commodity', ['commodities' => $commodities], ['data' => [$request->from, $request->to, $commodity_total->totaltotal, $commodity_total->paidtotal, $commodity_total->duetotal]]);
        $fileName = date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->stream($fileName);
    }

    public function getPDFStock(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = date("Y-m-d H:i:s", strtotime($request->from));
        $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));
        $stocks = Stock::whereBetween('created_at', [$from, $to])
                        ->where('quantity', '>', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $pdf = PDF::loadView('reports.pdf.stock', ['stocks' => $stocks], ['date' => [$request->from, $request->to]]);
        $fileName = date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->stream($fileName);
    }

    public function getPDFSource(Request $request)
    {
        //validation
        $this->validate($request, array(
          'source_id' => 'required',
          'source_report_type' => 'required',
        ));

        $source = Source::find($request->source_id);
        if($request->source_report_type == 'all') {
          $sources = Commodity::where('source_id', $request->source_id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        } elseif ($request->source_report_type == 'justdue') {
          $sources = Commodity::where('source_id', $request->source_id)
                        ->where('due', '!=', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();
        }
        
        $source_total = DB::table('commodities')
                        ->select('source_id', DB::raw('SUM(total) as totalsource'), DB::raw('SUM(paid) as paidsource'), DB::raw('SUM(due) as duesource'))
                        ->where('source_id', $request->source_id)
                        ->first();

        $pdf = PDF::loadView('reports.pdf.source', ['sources' => $sources], ['source_data' => [$source->name, $source_total->totalsource, $source_total->paidsource, $source_total->duesource]]);
        $fileName = $source->name .'.pdf';
        return $pdf->stream($fileName);
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
        $usages = Usage::whereBetween('created_at', [$from, $to])
                        ->orderBy('created_at', 'desc')
                        ->get();
        $pdf = PDF::loadView('reports.pdf.usage', ['usages' => $usages], ['date' => [$request->from, $request->to]]);
        $fileName = date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->stream($fileName);
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
                        ->select('created_at', DB::raw('SUM(total) as totalsale'))
                        ->where('isdeleted', '=', 0)
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->whereBetween('created_at', [$from, $to])
                        ->orderBy('created_at', 'desc')
                        ->get();
        $incomes_total = DB::table('receipts')
                        ->select(DB::raw('SUM(total) as totalgross'))
                        ->where('isdeleted', '=', 0)
                        ->whereBetween('created_at', [$from, $to])
                        ->first();
        $pdf = PDF::loadView('reports.pdf.income', ['incomes' => $incomes], ['data' => [$request->from, $request->to, $incomes_total->totalgross]]);
        $fileName = date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->stream($fileName);
    }
}
