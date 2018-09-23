@extends('layouts.app')

@section('title', 'Queen Island Kitchen')

@section('css')
<style type="text/css">
    .shadow {
      -webkit-box-shadow: 5px 5px 20px 0px rgba(133,121,133,1);
      -moz-box-shadow: 5px 5px 20px 0px rgba(133,121,133,1);
      box-shadow: 5px 5px 20px 0px rgba(133,121,133,1);
    }
    .clock {
      zoom: 0.8;
      -moz-transform: scale(0.8);
    }
</style>
@stop

@section('content')
<div class="container">
      <div class="well">
        <div class="row">
          <div class="col-md-5">
            <img src="{{ asset('images/coding.gif') }}" class="img-responsive shadow">
          </div>
          <div class="col-md-7">
            <div class="clock" style="margin: 2em;"></div>
          </div>
        </div>
      </div>
      <center>
        <h2 style="color: green">This website is under construction.</h2>
        <p>&copy; <?php echo date('Y'); ?> Copyright Reserved.</p>
      </center>
</div>
@endsection

@section('js')
<script type="text/javascript">
  var date = new Date("October 01, 2018 02:15:00"); //Month Days, Year HH:MM:SS
  var now = new Date();
  var diff = (date.getTime()/1000) - (now.getTime()/1000);
  console.log(diff);

  if(diff > 0) {
    var clock = $('.clock').FlipClock(diff,{
        clockFace: 'DailyCounter',
        countdown: true
    });
  }

  $(document).ready(function(){
      if ($(window).width() < 800) {
         $('.clock').attr('style', 'margin: 3em; zoom: 0.4;-moz-transform: scale(0.4);');
      }
  });

</script>
@stop

