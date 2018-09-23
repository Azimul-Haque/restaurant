@extends('adminlte::page')

@section('title', 'Restaurant ABC | Expenditure')

@section('content_header')
    <h1>
      Expenditure
      <div class="pull-right">
        
      </div>
  </h1>
@stop

@section('content')
  @permission('receipt-crud')
    <div class="row">
      <div class="col-md-6">
        <div class="small-box bg-red">
          <div class="inner">
            <h3>৳ 
            @if(empty($todaysexpense->totalprice))
            0.00
            @else
            {{ $todaysexpense->totalprice }}
            @endif
            /-</h3>

            <p>Today's Expenditure</p>
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

            <h3 class="box-title">This Month's Expenditure</h3>
            <div class="box-tools pull-right">
              {{ date('F Y') }}
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table" id="datatable-dailyexpense">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Total (৳)</th>
                  </tr>
                </thead>
                @foreach($thismonthsexpense as $dailyexpense)
                <tr>
                  <td>{{ date('F d, Y', strtotime($dailyexpense->created_at)) }}</td>
                  <td>৳ {{ $dailyexpense->totalprice }}/-</td>
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

            <h3 class="box-title">This Year's Expenditure</h3>
            <div class="box-tools pull-right">
              Year: {{ date('Y') }}
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table" id="datatable-monthlyexpense">
                <thead>
                  <tr>
                    <th>Month</th>
                    <th>Total (৳)</th>
                  </tr>
                </thead>
                @foreach($thisyearsexpense as $monthlyexpense)
                <tr>
                  <td>{{ date('F, Y', strtotime($monthlyexpense->created_at)) }}</td>
                  <td>৳ {{ $monthlyexpense->totalprice }}/-</td>
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
  <script type="text/javascript">
    $(function () {
      $('#datatable-dailyexpense').DataTable({
        'paging'      : true,
        'pageLength'  : 5,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'order': [[ 0, "desc" ]],
        columnDefs: [
              { targets: [0], type: 'date'}
        ]
      });
      $('#datatable-monthlyexpense').DataTable({
        'paging'      : true,
        'pageLength'  : 5,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'order': [[ 0, "desc" ]],
        columnDefs: [
              { targets: [0], type: 'date'}
        ]
      });
    })
  </script>
@stop