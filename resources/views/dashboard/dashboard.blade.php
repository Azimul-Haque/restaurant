@extends('adminlte::page')

@section('title', 'QIK | Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12" style="" align="center">
          <div class="btn-group-vertical">
            <div class="">
              <div class="btn-group">
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Administration
                </button>
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Students
                </button>
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Result
                </button>
              </div>
            </div>
            <div class="">
              <div class="btn-group">
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </button>
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </button>
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </button>
              </div>
            </div>
            <div class="">
              <div class="btn-group">
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </button>
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </button>
                <button type="button" class="btn btn-default dashboard-box-button">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </button>
              </div>
            </div>
          </div>
        </div>
    </div>
@stop

@section('js')
<script type="text/javascript">
  
  $(document).ready(function(){
    if ($(window).width() < 960) {
       //alert('Less than 960');
    }
  }); 
</script>
@stop