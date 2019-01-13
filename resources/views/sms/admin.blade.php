@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | SMS Admin')

@section('content_header')
  <h1>
    SMS Admin
    <div class="pull-right">

    </div>
  </h1>
@stop

@section('content')
  @if((Auth::user()->name == 'Admin') || (Auth::user()->name == 'Developer'))
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="info-box">
            <span class="info-box-icon bg-green"><span class="glyphicon glyphicon-import"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Actual Balance</span>
              <span class="info-box-number">
                ৳ {{ $actualbalance }}
              </span>
              <span class="info-box-text">Available SMS: {{ (int) ($actualbalance / 0.20) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-box">
            <span class="info-box-icon bg-red"><span class="glyphicon glyphicon-export"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">QIK Balance</span>
              <span class="info-box-number">
                SMS Count:
              </span>
              <span class="info-box-text"><big>{{ $qikbalance->balance }}</big></span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
      </div>

      <div class="box box-primary" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-battery-full"></i>

          <h3 class="box-title">Recharge SMS</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['route' => ['sms.addsms'], 'method' => 'POST']) !!}
               <div class="form-group">
                 <label for="smsamount">SMS Amount:</label>
                 <input type="number" name="smsamount" class="form-control"" required="" placeholder="SMS Amount">
               </div>
               <button class="btn btn-primary" type="submit">Add SMS</button>
            {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-success" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-paper-plane"></i>

          <h3 class="box-title">Send SMS</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  @else
  <h3 style="color: red;">
    <i class="fa fa-exclamation-triangle"></i> You are not allowed to see things here!
  </h3>
  @endif
@stop


@section('js')
  <script type="text/javascript" src="{{ asset('js/smscounter.js') }}"></script>
  <script type="text/javascript">
    
  </script>
@stop