@extends('adminlte::page')

@section('title', 'Restaurant ABC | Receipts')

@section('content_header')
    <h1>
      Accounts
      <div class="pull-right">
        
      </div>
  </h1>
@stop

@section('content')
  @permission('receipt-crud')
    <div class="row">
      <div class="col-md-6">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>৳ 
            @if(empty($todayscollection[0]->totalprice))
            0.00
            @else
            {{ $todayscollection[0]->totalprice }}
            @endif
            /-</h3>

            <p>Today's Collection</p>
          </div>
          <div class="icon">
            <i class="ion ion-calendar"></i>
          </div>
          <span class="small-box-footer">{{ date('l | F d, Y') }}</span>
        </div>

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
            <canvas id="myChart"></canvas>
          </div>
          <!-- /.box-body -->
        </div>
      </div>

      <div class="col-md-6">
        <div class="box box-primary" style="position: relative; left: 0px; top: 0px;">
          <div class="box-header ui-sortable-handle" style="">
            <i class="fa fa-calculator"></i>

            <h3 class="box-title">This Month's Collection</h3>
            <div class="box-tools pull-right">
              {{ date('F Y') }}
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Total (৳)</th>
                  </tr>
                </thead>
                @foreach($thismonthscollection as $dailycollection)
                <tr>
                  <td>{{ date('F d, Y', strtotime($dailycollection->created_at)) }}</td>
                  <td>৳ {{ $dailycollection->totalprice }}/-</td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box box-warning" style="position: relative; left: 0px; top: 0px;">
          <div class="box-header ui-sortable-handle" style="">
            <i class="fa fa-calculator"></i>

            <h3 class="box-title">This Year's Collection</h3>
            <div class="box-tools pull-right">
              {{ date('F Y') }}
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Month</th>
                    <th>Total (৳)</th>
                  </tr>
                </thead>
                @foreach($thisyearscollection as $monthlycollection)
                <tr>
                  <td>{{ date('F, Y', strtotime($monthlycollection->created_at)) }}</td>
                  <td>৳ {{ $monthlycollection->totalprice }}/-</td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  @endpermission
@stop


@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

  <script type="text/javascript">
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'line',

          // The data for our dataset
          data: {
              labels: {!! $datesforchart !!},
              datasets: [{
                  label: '',
                  borderColor: "#3e95cd",
                  fill: true,
                  data: {!! $totalsforchart !!},
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