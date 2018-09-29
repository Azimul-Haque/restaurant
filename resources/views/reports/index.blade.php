@extends('adminlte::page')

@section('title', 'Restaurant ABC | Stocks')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Report Management
      <div class="pull-right">
        
      </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="box box-primary">
            <div class="box-header with-border text-blue">
              <i class="fa fa-fw fa-bar-chart"></i>

              <h3 class="box-title">Expenditure Reports</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p class="text-blue"><b><u>Commodity Expenditure:</u></b></p>
              {!! Form::open(['route' => 'reports.getcommoditypdf', 'method' => 'GET', 'target' => '_blank']) !!}
                <div class="form-group">
                  {!! Form::text('from', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromcomexDate', 'autocomplete' => 'off')) !!}
                </div>
                <div class="form-group">
                  {!! Form::text('to', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tocomexDate', 'autocomplete' => 'off')) !!}
                </div>
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
    </div>
    <div class="col-md-3">
      <div class="box box-success">
            <div class="box-header with-border text-green">
              <i class="fa fa-shopping-bag"></i>

              <h3 class="box-title">Source/ দোকানের হিসাব</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p class="text-green"><b><u>Source:</u></b></p>
              {!! Form::open(['route' => 'reports.getsourcepdf', 'method' => 'GET', 'target' => '_blank']) !!}
                <div class="form-group">
                  <select class="form-control text-green" name="source_id" required="">
                      <option value="" selected="" disabled="">Select Source</option>
                    @foreach($sources as $source)
                      <option value="{{ $source->id }}">{{ $source->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <select class="form-control text-green" name="source_report_type" required="">
                    <option value="" selected="" disabled="">রিপোর্টের ধরণ</option>
                    <option value="all">সম্পূর্ণ পরিশোধের হিসাবসহ</option>
                    <option value="justdue">শুধু বাকির হিসাব</option>
                  </select>
                </div>
              <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
    </div>
    <div class="col-md-3">
      <div class="box box-warning">
            <div class="box-header with-border text-yellow">
              <i class="fa fa-balance-scale"></i>

              <h3 class="box-title">Usages</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p class="text-yellow"><b><u>Usage List:</u></b></p>
              {!! Form::open(['route' => 'reports.getusagepdf', 'method' => 'GET', 'target' => '_blank']) !!}
                <div class="form-group">
                  {!! Form::text('from', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromusageDate', 'autocomplete' => 'off')) !!}
                </div>
                <div class="form-group">
                  {!! Form::text('to', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tousageDate', 'autocomplete' => 'off')) !!}
                </div>
              <button class="btn btn-warning" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
    </div>
    <div class="col-md-3">
      <div class="box box-danger">
            <div class="box-header with-border text-red">
              <i class="fa fa-cog"></i>

              <h3 class="box-title">Alerts</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p class="text-red">কাজ চলছে</p>
            </div>
            <!-- /.box-body -->
          </div>
    </div>
  </div>
@stop


@section('js')
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript">
      $(function() {
        $("#fromcomexDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#tocomexDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#fromusageDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#tousageDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
      });
  </script>
@stop