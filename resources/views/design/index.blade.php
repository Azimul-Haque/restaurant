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
    <h1><i class="fa fa-cogs"></i> Home Page Design</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
          <div class="box box-success noPrint">
            <div class="box-header with-border">
              <h3 class="box-title"><b>আমাদের সম্পর্কে</b>-এর টেক্সট <small>(যেখানে <b>আপনার স্বাদ আমাদের দায়িত্ব</b> লেখা আছে তার নিচের টেক্সট)</small></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'design.store.aboutus', 'method' => 'POST']) !!}
              <div class="box-body">
                <div class="form-group">
                  {!! Form::label('text', 'টেক্সটঃ (সর্বোচ্চ ২০০ শব্দ)') !!}
                  <textarea name="text" class="form-control" style="height: 100px; resize: none;" placeholder="আমাদের সম্পর্কে লিখুন" required="">{{ $aboutus->text }}</textarea>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success btn-block')) !!}
              </div>
            {!! Form::close() !!}
          </div>

          <div class="box box-warning noPrint">
            <div class="box-header with-border">
              <h3 class="box-title"><b>স্লাইডার ছবির তালিকা</b> <small>(<b>এই মুহূর্তে আমাদের মেন্যুর শীর্ষে</b>-এর নিচের ছবিগুলো)</small></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addSliderImage" data-backdrop="static"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> স্লাইডারের ছবি যোগ করুন</button>
                {{-- add stuff payment modal--}}
                  <!-- Modal -->
                  <div class="modal fade" id="addSliderImage" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header modal-header-warning">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">স্লাইডারের ছবি যোগ করুন</h4>
                        </div>
                        <div class="modal-body">
                          <!-- form start -->
                          {!! Form::open(['route' => 'design.store.sliderimg', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <div class="form-group">
                              <label for="item">ছবির খাদ্যপণ্যের নামঃ</label>
                              <input type="text" name="item" class="form-control" placeholder="আইটেমের নাম লিখুন" required="">
                            </div>
                            <div class="form-group">
                              <label for="description">ছবির বিবরণঃ (২০ শব্দের মধ্যে)</label>
                              <input type="text" name="description" class="form-control" placeholder="আইটেমের বিবরণ লিখুন" required="">
                            </div>
                            <div class="form-group">
                                <label><strong>ছবিঃ (300 X 250 এবং 200Kb সর্বোচ্চ)</strong></label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            ছবি জুড়ুন<input type="file" id="image" name="image" required="">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <img src="{{ asset('images/cooker-img.png')}}" id='img-upload' style="height: 200px; width: auto; padding: 5px;" />

                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-warning')) !!}
                          {!! Form::close() !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            
            <div class="box-body">
              <table class="table" id="">
                <thead>
                  <tr>
                    <th>ছবি আইটেম</th>
                    <th>ছবি</th>
                    <th width="20%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sliders as $slider)
                  <tr>
                    <td>{{ $slider->item }}</td>
                    <td>
                      <img src="{{ asset('images/slider/'.$slider->image) }}" style="height: 80px; width: auto;">
                    </td>
                    <td>
                      {{-- Delete Menu Item --}}
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteSlider{{ $slider->id }}" data-backdrop="static" title="ছবি ডিলেট করুন"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      <!-- Trigger the modal with a button -->
                      <!-- Modal -->
                      <div class="modal fade" id="deleteSlider{{ $slider->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header modal-header-danger">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Delete Confirmation</h4>
                            </div>
                            <div class="modal-body">
                              Delete this Image Item?<br/><br/>
                              {{ $slider->item }}<br/>
                              <img src="{{ asset('images/slider/'.$slider->image) }}" style="height: 100px; width: auto;">
                            </div>
                            <div class="modal-footer">
                              {!! Form::model($slider, ['route' => ['design.destroy.slideritem', $slider->id], 'method' => 'DELETE']) !!}
                                  <button type="submit" class="btn btn-danger">Delete</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- Delete Menu Item --}}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $sliders->links() }}
            </div>
          </div>

        </div>

        <div class="col-md-6">
          <div class="box box-primary noPrint">
            <div class="box-header with-border">
              <h3 class="box-title"><b>মেন্যু তালিকা</b> <small>(যেখানে <b>এ সপ্তাহের ফিচার</b> লেখা আছে তার নিচের তালিকাটি)</small></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addMenuItem" data-backdrop="static"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> মেন্যু আইটেম যোগ করুন</button>
                {{-- add stuff payment modal--}}
                  <!-- Modal -->
                  <div class="modal fade" id="addMenuItem" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">মেন্যু আইটেম যোগ করুন</h4>
                        </div>
                        <div class="modal-body">
                          <!-- form start -->
                          {!! Form::open(['route' => 'design.store.menuitem', 'method' => 'POST']) !!}
                            <div class="form-group">
                              <label for="item">মেন্যু আইটেমের নামঃ <small>ইংরেজি নাম (বাংলা নাম) এভাবে লিখুন</small></label>
                              <input type="text" name="item" class="form-control" placeholder="যেমনঃ French Fry (ফ্রেঞ্চ ফ্রাই) এভাবে লিখুন" required="">
                            </div>
                            <div class="form-group">
                              {!! Form::label('price', 'মূল্যঃ (ইংরেজি সংখ্যা লিখুন)') !!}
                              {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'মূল্য লিখুন', 'step' => 'any', 'required' => '', 'min' => 0)) !!}
                            </div>
                            <div class="form-group">
                              {!! Form::label('description', 'ছোট করে বিবরণ দিন') !!}
                              {!! Form::text('description', null, array('class' => 'form-control', 'placeholder' => 'বিবরণ দিন', 'required' => '')) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary')) !!}
                          {!! Form::close() !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            
            <div class="box-body">
              <table class="table" id="">
                <thead>
                  <tr>
                    <th>মেন্যু আইটেম</th>
                    <th>মূল্য</th>
                    <th width="20%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($menus as $menu)
                  <tr>
                    <td title="বিবরণঃ {{ $menu->description }}" data-placement="left">{{ $menu->item }}</td>
                    <td>{{ $menu->price }} ৳</td>
                    <td>
                      {{-- Edit Menu Item --}}
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editMenuItem{{ $menu->id }}" data-backdrop="static" title="মেন্যু আইটেম এডিট করুন"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></button>
                      {{-- add stuff payment modal--}}
                        <!-- Modal -->
                        <div class="modal fade" id="editMenuItem{{ $menu->id }}" role="dialog">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header modal-header-primary">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">মেন্যু আইটেম এডিট করুন</h4>
                              </div>
                              <div class="modal-body">
                                <!-- form start -->
                                {!! Form::model($menu, ['route' => ['design.update.menuitem', $menu->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                                  <div class="form-group">
                                    <label for="item">মেন্যু আইটেমের নামঃ <small>ইংরেজি নাম (বাংলা নাম) এভাবে লিখুন</small></label>
                                    {!! Form::text('item', null, array('class' => 'form-control', 'placeholder' => 'যেমনঃ French Fry (ফ্রেঞ্চ ফ্রাই) এভাবে লিখুন', 'required' => '')) !!}
                                  </div>
                                  <div class="form-group">
                                    {!! Form::label('price', 'মূল্যঃ (ইংরেজি সংখ্যা লিখুন)') !!}
                                    {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'মূল্য লিখুন', 'step' => 'any', 'required' => '', 'min' => 0)) !!}
                                  </div>
                                  <div class="form-group">
                                    {!! Form::label('description', 'ছোট করে বিবরণ দিন') !!}
                                    {!! Form::text('description', null, array('class' => 'form-control', 'placeholder' => 'বিবরণ দিন', 'required' => '')) !!}
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary')) !!}
                                {!! Form::close() !!}
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      {{-- Edit Menu Item --}}
                      {{-- Delete Menu Item --}}
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteMenuItemModal{{ $menu->id }}" data-backdrop="static" title="মেন্যু আইটেম ডিলেট করুন"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      <!-- Trigger the modal with a button -->
                      <!-- Modal -->
                      <div class="modal fade" id="deleteMenuItemModal{{ $menu->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header modal-header-danger">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Delete Confirmation</h4>
                            </div>
                            <div class="modal-body">
                              Delete this item?
                            </div>
                            <div class="modal-footer">
                              {!! Form::model($menu, ['route' => ['design.destroy.menuitem', $menu->id], 'method' => 'DELETE']) !!}
                                  <button type="submit" class="btn btn-danger">Delete</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- Delete Menu Item --}}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $menus->links() }}
            </div>
          </div>
        </div>
    </div>
@stop

@section('js')
  <script type="text/javascript">
    $(document).ready(function(){
      $('a[title]').tooltip();
      $('button[title]').tooltip();
      $('span[title]').tooltip();
    });
  </script>
  <script type="text/javascript">
    $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
      });

      $('.btn-file :file').on('fileselect', function(event, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = label;
          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
      });
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image").change(function(){
          readURL(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 200) {
            $("#image").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 200Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/cooker-img.png') }}');
              }, 1000);
          }
      });

    });
  </script>
@stop