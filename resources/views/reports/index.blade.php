@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Stocks')

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
          <h3 class="box-title">Commodity Reports</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'reports.getcommoditypdf', 'method' => 'GET', 'target' => '_blank']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromcomexDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tocomexDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
          <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <div class="box box-primary">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-exchange"></i>
          <h3 class="box-title">Stock Reports</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'reports.getstockpdf', 'method' => 'GET', 'target' => '_blank']) !!}
            <div class="form-group">
              <select class="form-control text-green" name="stock_report_type" required="">
                <option value="" selected="" disabled="">রিপোর্টের ধরণ</option>
                <option value="all">শেষ হয়ে যাওয়া সামগ্রীসহ</option>
                <option value="onlyexisting">শুধুমাত্র বিদ্যমান সামগ্রীগুলো</option>
              </select>
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
          <i class="fa fa-fw fa-shopping-bag"></i>
          <h3 class="box-title">Source/ দোকানের হিসাব</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'reports.getsourcepdf', 'method' => 'GET']) !!}
            <div class="form-group">
              <select class="form-control text-green" name="source_id" required="">
                  <option value="" selected="" disabled="">Select Source</option>
                @foreach($sources as $source)
                  <option value="{{ $source->id }}">{{ $source->name }}</option>
                @endforeach
              </select>
            </div>
            {{-- <div class="form-group">
              <select class="form-control text-green" name="source_report_type" required="">
                <option value="" selected="" disabled="">রিপোর্টের ধরণ</option>
                <option value="all">সম্পূর্ণ পরিশোধের হিসাবসহ</option>
                <option value="justdue">শুধু বাকির হিসাব</option>
              </select>
            </div> --}}
            <div class="row">
              <div class="form-group col-md-6">
                {!! Form::text('from', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'From Date', 'id' => 'fromsourceDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
              <div class="form-group col-md-6">
                {!! Form::text('to', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'To Date', 'id' => 'tosourceDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
            </div>
            <div class="">
              <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
              <button class="btn btn-gray" type="submit" style="float: right;" formaction="{{ route('reports.getsourcepos') }}"><i class="fa fa-fw fa-print" aria-hidden="true"></i> POS Print</button>
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <div class="box box-success">
        <div class="box-header with-border text-green">
          <i class="fa fa-fw fa-trophy"></i>
          <h3 class="box-title">Membership</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'reports.getmembers', 'method' => 'GET']) !!}
            <div class="form-group">
              <select class="form-control text-green" name="members_report_type" required="">
                <option value="" selected="" disabled="">রিপোর্টের ধরণ</option>
                <option value="onlyawarded">ন্যূনতম একবার পুরষ্কারপ্রাপ্ত</option>
                <option value="neverawarded">একবারও পুরষ্কারপ্রাপ্ত নন</option>
                <option value="all">সবাই</option>
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
          {!! Form::open(['route' => 'reports.getusagepdf', 'method' => 'GET']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromusageDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tousageDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
          <button class="btn btn-warning" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <div class="box box-warning">
        <div class="box-header with-border text-yellow">
          <i class="fa fa-cutlery"></i>
          <h3 class="box-title">Items Sales</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'reports.getitemsdatewise', 'method' => 'GET', 'target' => '_blank']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromitemsdatewiseDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'toitemsdatewiseDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
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
          <i class="fa fa-fw fa-line-chart"></i>
          <h3 class="box-title">Income</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'reports.getincomepdf', 'method' => 'GET']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-red', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromincomeDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-red', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'toincomeDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
          <button class="btn btn-danger" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <div class="box box-danger">
        <div class="box-header with-border text-red">
          <i class="fa fa-fw fa-envelope-o"></i>
          <h3 class="box-title">SMS Report</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'reports.getsmshistory', 'method' => 'GET', 'target' => '_blank']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-red', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromsmsDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-red', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tosmsDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
          <button class="btn btn-danger" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
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
        $("#fromsourceDate").datepicker({
          format: 'dd-mm-yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#tosourceDate").datepicker({
          format: 'dd-mm-yyyy',
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
        $("#fromincomeDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#toincomeDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#fromitemsdatewiseDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#toitemsdatewiseDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#fromsmsDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
        $("#tosmsDate").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true,
        });
      });
  </script>
@stop