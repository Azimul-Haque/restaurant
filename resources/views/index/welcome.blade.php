<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Queen Island Kitchen | Feel The Food</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" sizes="192x192" href="{{ asset('images/icon.png') }}">
    <meta name="theme-color" content="#AD7E61">
    <meta name="msapplication-navbutton-color" content="#AD7E61">
    <meta name="apple-mobile-web-app-status-bar-style" content="#AD7E61">
    <meta name="description" content="Official website of Queen Island Kitchen, Press Club Bulding, Bhola-8300, Bangladesh. &copy; {{ date('Y') }} Copyright Reserved. Developed By A. H. M. Azimul Haque. Slogan: *** FEEL THE FOOD ***"/>
    <!-- CSS
        ================================================ -->
        <!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css">
        <!-- bootstrap.min css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Font-awesome.min css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="css/animate.min.css">

    <link rel="stylesheet" href="css/main.css">
        <!-- Responsive Stylesheet -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Js -->
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
    <script src="js/jquery.nav.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/main.js"></script>
  </head>
  <body>
  <!--
  header-img start 
  ============================== -->
    <section id="hero-area">
      <img class="img-responsive" src="images/header.jpg" alt="">
    </section>
  <!--
    Header start 
  ============================== -->
  <nav id="navigation">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <nav class="navbar navbar-default">
                          <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                              </button>
                                  <a class="navbar-brand QIKBanner-brand" href="#">
                                    <h1 class="QIKBanner"><b>Queen Island</b> Kitchen</h1>
                                  </a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                              <ul class="nav navbar-nav navbar-right" id="top-nav">
                                <li><a href="#hero-area">নীড় পাতা</a></li>
                                <li><a href="#about-us">আমাদের সম্পর্কে</a></li>
                                <li><a href="#price">মেন্যু</a></li>
                                {{-- <li><a href="#subscribe">news</a></li> --}}
                                <li><a href="#membership">মেম্বারশিপ</a></li>
                                <li><a href="#contact-us">যোগাযোগ</a></li>
                              </ul>
                            </div><!-- /.navbar-collapse -->
                          </div><!-- /.container-fluid -->
                        </nav>
                    </div>
                </div><!-- .col-md-12 close -->
            </div><!-- .row close -->
        </div><!-- .container close -->
  </nav><!-- header close -->
    <!--
    Slider start
    ============================== -->
    <section id="slider">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
                        <div class="title">
                            <h3>এই মুহূর্তে আমাদের <span>মেন্যুর শীর্ষে...</span></h3>
                        </div>
                        <div id="owl-example" class="owl-carousel">
                            @foreach($sliders as $slider)
                            <div>
                                <img class="img-responsive" src="{{ asset('images/slider/'.$slider->image) }}" alt="">
                                <span>{{ $slider->item }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div><!-- .col-md-12 close -->
            </div><!-- .row close -->
        </div><!-- .container close -->
    </section><!-- slider close -->
    <!--
    about-us start
    ============================== -->
    <section id="about-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <center>
                            <img class="wow fadeInUp img-responsive img-circle" data-wow-duration="300ms" data-wow-delay="400ms" src="images/cooker-img.png" alt="cooker-img" style="max-height: 200px; border: 5px solid #dddddd;">
                        </center>
                        <h1 class="heading wow fadeInUp" data-wow-duration="400ms" data-wow-delay="500ms" >আপনার <span>স্বাদ</span> </br> আমাদের <span>দায়িত্ব</span>
                        </h1>
                        <p class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="600ms">
                            {{ $aboutus->text }}
                        </p>
                    </div>
                </div><!-- .col-md-12 close -->
            </div><!-- .row close -->
        </div><!-- .containe close -->
    </section><!-- #call-to-action close -->
    <!--
    blog start
    ============================ -->
    <section id="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <h1 class="heading">আপনার জন্য <span style="background: rgba(0, 0, 0, 0.5);">আমাদের</span> সর্বশেষ <span style="background: rgba(0, 0, 0, 0.5);">সংযোজন</span></h1>
                        <ul>
                            @php
                                $sixslideritemwowdelay = 300;
                                $i = 1;
                                $i_array = [1, 2, 5, 6];
                            @endphp
                            @foreach($sixsliders as $slider)
                            <li class="wow fadeInLeft" data-wow-duration="300ms" data-wow-delay="{{ $sixslideritemwowdelay }}ms">
                                <div @if(in_array($i, $i_array)) class="blog-img" @else class="blog-img-2" @endif>
                                    <img src="{{ asset('images/slider/'.$slider->image) }}" alt="blog-img">
                                </div>
                                <div @if(in_array($i, $i_array)) class="content-right" @else class="content-left" @endif>
                                    <h4 class="img-content-header">{{ $slider->item }}</h4>
                                    <p><small>{{ $slider->description }}</small></p>
                                </div>
                            </li>
                            @php
                                $sixslideritemwowdelay = $sixslideritemwowdelay + 100;
                                $i++;
                            @endphp
                            @endforeach
                        </ul>
                        {{-- <a class="btn btn-default btn-more-info wow bounceIn" data-wow-duration="500ms" data-wow-delay="1200ms" href="#" role="button">More Info</a> --}}
                    </div>
                </div><!-- .col-md-12 close -->
            </div><!-- .row close -->
        </div><!-- .containe close -->
    </section><!-- #blog close -->
    <!--
    price start
    ============================ -->
    <section id="price">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <h1 class="heading wow fadeInUp" data-wow-duration="300ms" data-wow-delay="300ms">আমাদের <span>মেন্যু</span> এবং <span>মূল্যতালিকা</span></h1>
                        <p class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="400ms">আমাদের মেন্যু (আইটেম তালিকা) এবং আপডেটেড মূল্যতালিকা, এখন মূল্য এবং রুচির কথা মাথায় রেখে বাজেট করে ফেলুন, অনলাইনেই পেয়ে যাচ্ছেন আমাদের সকল খাদ্যপণ্যের সঠিক মূল্যটি....</p>
                        <div class="pricing-list">
                            <div class="title">
                                <h3>এ সপ্তাহের <span>ফিচার</span></h3>
                            </div>
                            <ul>
                                @php
                                    $menuitemwowdelay = 300;
                                @endphp
                                @foreach($menus as $menu)
                                <li class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="{{ $menuitemwowdelay }}ms">
                                    <div class="item">
                                        <div class="item-title">
                                            <h2>{{ $menu->item }}</h2>
                                            <div class="border-bottom"></div>
                                            <span>৳ {{ $menu->price }}</span>
                                        </div>
                                        <p>{{ $menu->description }}</p>
                                    </div>
                                </li>
                                @php
                                    $menuitemwowdelay = $menuitemwowdelay + 100;
                                @endphp
                                @endforeach
                                
                            </ul>
                            <button class="btn btn-default pull-right wow bounceIn" data-wow-duration="500ms" data-wow-delay="1000ms" data-toggle="modal" data-target="#seeMoreMenu" data-backdrop="static">আরো দেখুন...</button>
                            <!-- Modal -->
                            <div class="modal fade" id="seeMoreMenu" role="dialog" style="z-index: 999999;">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header modal-header-danger">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">সম্পূর্ণ মেন্যু তালিকা</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>আইটেম</th>
                                                    <th width="20%">মূল্য</th>
                                                    <th width="40%">বিবরণ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($allmenus as $menu)
                                                <tr>
                                                    <td>{{ $menu->item }}</td>
                                                    <td>{{ $menu->price }} ৳</td>
                                                    <td>{{ $menu->description }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">আচ্ছা</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .col-md-12 close -->
            </div><!-- .row close -->
        </div><!-- .containe close -->
    </section><!-- #price close -->
    <!--
    subscribe start
    ============================ -->
    <section id="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <h1 class="heading wow fadeInUp" data-wow-duration="300ms" data-wow-delay="300ms"> আমাদের <span style="background: rgba(0, 0, 0, 0.5); font-family: myfont">SMS</span> আপডেট এবং <span style="background: rgba(0, 0, 0, 0.5);">ডিসকাউন্ট</span> পেতে আপনার নম্বরটি দিন</h1>
                        <p class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="400ms">আপনার নম্বরটি আমাদের কাছে গোপন থাকবে, প্রোমো এবং অফার সংক্রান্ত এসএমএস আপনাকে পাঠানো হবে</p>
                        {!! Form::open(['route' => 'index.subscribe', 'method' => 'POST', 'class' => 'form-inline']) !!}
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" id="exampleInputAmount" placeholder="আপনার নামঃ" required="">
                                    <input type="text" name="phone" class="form-control" id="exampleInputAmount" placeholder="১১ ডিজিট মোবাইল নম্বর (ইংরেজিতে)" pattern="\d*" minlength="11" maxlength="11" autocomplete="off" required="">
                                    @php
                                        $num1 = rand(1,9);
                                        $num2 = rand(1,9);
                                        $sum = $num1 + $num2;
                                    @endphp
                                    <input type="number" name="captchasum" class="form-control" id="exampleInputAmount" placeholder="{{ $num1 }} ও {{ $num2 }} এর যোগফল ইংরেজিতে লিখুন" required="">
                                    <input type="hidden" name="hiddencaptchasum" value="{{ $sum }}">
                                    <div class="input-group-addon">
                                        <button class="btn btn-default" type="submit">সাবস্ক্রাইব</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div><!-- .col-md-12 close -->
            </div><!-- .row close -->
        </div><!-- .containe close -->
    </section><!-- #subscribe close -->
    <!--
    membership start
    ============================ -->
    <section id="membership">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <h1 class="heading wow fadeInUp" data-wow-duration="300ms" data-wow-delay="300ms"> আমাদের একজন <span>গর্বিত মেম্বার</span> হয়ে যান আজই!</h1>
                        <center><h2 style="margin-bottom: 20px;" class="wow fadeInUp">পরিপূর্ণ মেম্বারশিপ পেতে অনুগ্রহ করে কুইন আইল্যান্ড কিচেনে আসুন</h2></center>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table wow fadeInUp">
                        <tr>
                            <th>
                                <img src="{{ asset('images/icon.png') }}" style="width: 25px; height: auto;">
                                <span style="margin-left: 10px;">আমাদের প্রতিটি আইটেম অর্ডারে পৃথক পয়েন্ট যোগ হবে আপনার একাউন্টে</span>
                            </th>
                        </tr>
                        {{-- <tr>
                            <th>
                                <img src="{{ asset('images/icon.png') }}" style="width: 25px; height: auto;">
                                <span style="margin-left: 10px;">If 100 poits earned, gift can be claimed</span>
                            </th>
                        </tr> --}}
                        <tr>
                            <th>
                                <img src="{{ asset('images/icon.png') }}" style="width: 25px; height: auto;">
                                <span style="margin-left: 10px;">নির্দিষ্ট সংখ্যক পয়েন্ট জমা হলে মূল্যবান উপহার প্রদান করা হবে</span>
                            </th>
                        </tr>
                    </table></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-success wow fadeInUp">
                                <div class="panel-heading">আপনার পয়েন্ট চেক করুন</div>
                                <div class="panel-body">
                                    <div>
                                        <span id="error_message" style="color: red;"></span>
                                        <h3 id="member_name"></h3>
                                        <h3 id="member_phone"></h3>
                                        <h3 id="member_point"></h3>
                                    </div><br/>
                                    <div class="form-group">
                                        <label>মেম্বার আইডি/ ১১ ডিজিট মোবাইল নম্বরটি লিখুন</label>
                                        <input type="text" id="check_phone" class="form-control wow fadeInUp" autocomplete="on">
                                    </div>
                                    <button class="btn btn-success btn-block" id="check_button">চেক করুন</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#check_button").click(function(){
                            member_id = $('#check_phone').val().trim();
                            if(member_id == '') {
                                $('#error_message').show();
                                $('#error_message').text('আপনার মোবাইল নম্বরটি লিখুন');
                                $('#error_message').delay(2000).fadeOut('slow');
                                
                            } else {
                            $.get(window.location.protocol + "//" + window.location.host + "/member/points/" + member_id, function(data, status){
                                  //console.log("Data: " + data + "\nStatus: " + status);
                                  if(data == 'N/A') {
                                    $('#error_message').show();
                                    $('#error_message').text('পাওয়া যায়নি!');
                                    $('#error_message').delay(2000).fadeOut('slow');
                                    $('#member_name').text('');
                                    $('#member_phone').text('');
                                    $('#member_point').text('');
                                  } else {
                                    $('#member_name').text(data.name);
                                    $('#member_phone').text(data.phone);
                                    $('#member_point').text('মোট পয়েন্টঃ '+data.point);
                                  }
                              });
                            }
                        });
                    });
                </script>
            </div><!-- .row close -->
        </div><!-- .containe close -->
    </section><!-- #membership close -->
    <!--
    CONTACT US  start
    ============================= -->
    <section id="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <h1 class="heading wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">আমাদের সাথে <span>যোগাযোগ করুন</span></h1>
                        <h3 class="title wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">আমাদের <span>লিখুন</span> </h3>
                        <form>
                            <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="600ms">
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="আপনার নামঃ" required="" />
                            </div>
                            <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="800ms">
                                <input type="text" class="form-control" placeholder="আপনার ইমেইল এড্রেস" required="" />
                            </div>
                            <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1000ms">
                                <textarea class="form-control" rows="3" placeholder="আপনার বার্তাটি লিখুন" required=""></textarea>
                            </div>
                        </form>
                        <a class="btn btn-default wow bounceIn" data-wow-duration="500ms" data-wow-delay="1300ms" href="#contact-us" role="button">বার্তাটি পাঠান</a>
                    </div>
                </div><!-- .col-md-12 close -->
            </div><!-- .row close -->
        </div><!-- .container close -->
    </section><!-- #contact-us close -->
    <!--
    footer  start
    ============================= -->
    <section id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="block wow fadeInLeft"  data-wow-delay="200ms">
                        <h3>যোগাযোগের <span>তথ্যঃ</span></h3>
                        <div class="info">
                            <ul>
                                <li>
                                  <h4><i class="fa fa-phone"></i>ফোনঃ</h4>
                                  <p style="font-family: myfont;">+880 1704 828 518, +880 1611 828 518</p>
                                </li>
                                <li>
                                  <h4><i class="fa fa-map-marker"></i>ঠিকানাঃ</h4>
                                  <p>ভোলা প্রেস ক্লাব, ভোলা-৮৩০০</p>
                                </li>
                                <li>
                                  <h4><i class="fa fa-envelope"></i>ইমেলঃ</h4>
                                  <p style="font-family: myfont;">queenislandkitchen@gmail.com</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- .col-md-4 close -->
                <div class="col-md-4">
                    <div class="block wow fadeInLeft"  data-wow-delay="700ms">
                        <h3>সর্বশেষ <span>মেন্যু আইটেম</span> আপডেট</h3>
                        <div class="blog">
                            <ul>
                                @foreach($lasttwomenus as $lasttwomenu)
                                <li>
                                    <h4><a href="#">{{ date('F d, Y', strtotime($lasttwomenu->updated_at)) }}</a></h4>
                                    <p><b>{{ $lasttwomenu->item }}</b>, মূল্যঃ {{ $lasttwomenu->price }} ৳, বিবরণঃ {{ $lasttwomenu->description }}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- .col-md-4 close -->
                <div class="col-md-4">
                    <div class="block wow fadeInLeft"  data-wow-delay="1100ms">
                        <div class="gallary">
                            <h3>ছবি <span>প্রবাহ</span></h3>
                            <ul>
                                <li>
                                    <a href="#"><img src="images/photo/photo-1.jpg" alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="images/photo/photo-2.jpg" alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="images/photo/photo-3.jpg" alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="images/photo/photo-4.jpg" alt=""></a>
                                </li>
                            </ul>
                        </div>
                        <div class="social-media-link">
                            <h3>আমাদের <span>অনুসরণ করুন</span></h3>
                            <ul>
                                <li>
                                    <a href="#!">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/Queen-Island-Kitchen-211011202809953/?ref=br_rs" target="_blank">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#!">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- .col-md-4 close -->
            </div><!-- .row close -->
        </div><!-- .containe close -->
    </section><!-- #footer close -->
    <!--
    footer-bottom  start
    ============================= -->
    <footer id="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="block">
                        <p style="font-family: myfont;">Copyright &copy; {{ date('Y') }} - All Rights Reserved</a> | Developed by: <a href="http://orbachinujbuk.com/">A. H. M. Azimul Haque</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @include('partials._messages')
  </body>
</html>