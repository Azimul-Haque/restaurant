@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Dashboard')

@section('css')
    <style type="text/css">
      @-webkit-keyframes blinker {
        from {opacity: 1.0;}
        to {opacity: 0.0;}
      }
      .blink{
        text-decoration: blink;
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 0.6s;
        -webkit-animation-iteration-count:infinite;
        -webkit-animation-timing-function:ease-in-out;
        -webkit-animation-direction: alternate;
      }
    </style>
@stop

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-green"><span class="glyphicon glyphicon-import"></span></span>

                <div class="info-box-content">
                  <span class="info-box-text">Income</span>
                  <span class="info-box-number">
                    ৳ 
                    @if(empty($thismonthscollection->totalprice))
                    0.00
                    @else
                    {{ $thismonthscollection->totalprice }}
                    @endif
                  </span>
                  <span class="info-box-text">{{ date('F, Y') }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-red"><span class="glyphicon glyphicon-export"></span></span>

                <div class="info-box-content">
                  <span class="info-box-text">Expenditure</span>
                  <span class="info-box-number">
                    ৳ 
                    @if(empty($thismonthsexpense->totalprice))
                    0.00
                    @else
                    {{ $thismonthsexpense->totalprice }}
                    @endif
                  </span>
                  <span class="info-box-text">{{ date('F, Y') }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
          </div><br/>
          <div class="panel panel-success">
            <div class="panel-heading">
              <big class="blink">নতুন ফিচার!</big>
            </div>
            <div class="panel-body">
              <big>
                <ul>
                  <li>মেম্বারদের সিঙ্গেল SMS পাঠানো <b>(কাজ চলছে)</b></li>
                  <li><a href="{{ route('sms.index') }}">SMS Module</a> থেকে সকল মেম্বারকে SMS পাঠানো <b>(কাজ চলছে)</b></li>
                </ul>
              </big>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-success" style="position: relative; left: 0px; top: 0px;">
            <div class="box-header ui-sortable-handle" style="">
              <i class="fa fa-calculator"></i>

              <h3 class="box-title">Last 7 Day's Sales</h3>
              <div class="box-tools pull-right">
                {{ date('F Y') }}
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <canvas id="myChartC"></canvas>
            </div>
            <!-- /.box-body -->
          </div>

        </div>
    </div>
@stop

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

  <script type="text/javascript">
      var ctx = document.getElementById('myChartC').getContext('2d');
      var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'line',

          // The data for our dataset
          data: {
              labels: {!! $datesforchartc !!},
              datasets: [{
                  label: '',
                  borderColor: "#3e95cd",
                  fill: true,
                  data: {!! $totalsforchartc !!},
                  borderWidth: 2,
                  borderColor: "rgba(0,165,91,1)",
                  borderCapStyle: 'butt',
                  pointBorderColor: "rgba(0,165,91,1)",
                  pointBackgroundColor: "#fff",
                  pointBorderWidth: 1,
                  pointHoverRadius: 5,
                  pointHoverBackgroundColor: "rgba(0,165,91,1)",
                  pointHoverBorderColor: "rgba(0,165,91,1)",
                  pointHoverBorderWidth: 2,
                  pointRadius: 5,
                  pointHitRadius: 10,
              }]
          },

          // Configuration options go here
          options: {
            legend: {
                    display: false
            },
            elements: {
                line: {
                    tension: 0
                }
            }
          }
      });
  </script>
@stop