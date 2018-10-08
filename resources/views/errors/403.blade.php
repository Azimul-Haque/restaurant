@extends('adminlte::page')

@section('title', '403 Access Denied')

@section('stylesheet')
  {!!Html::style('css/stylesheet.css')!!}

@endsection


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="centering text-center error-container">
                <div class="text-center">
                    <h2 class="without-margin"><span class="text-danger"><big>Access Denied</big></span></h2>
                    <h4 class="text-danger">You do not have permission for this page.</h4>
                    <h4 class="text-danger">403</h4>
                </div>
                <div class="text-center">
                    <h3><small>Choose an option below</small></h3>
                </div>
                <hr>
                <ul class="pager">
                    <li><a href="/">← Go Back</a></li>
                    <li><a href="/dashboard">Home Page</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection