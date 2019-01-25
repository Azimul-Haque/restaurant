@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Stuffs')

@section('content_header')
    <h1>
      Stuffs Management
      <div class="pull-right">
        {{-- <button class="btn btn-primary" id="printBtn"><i class="fa fa-fw fa-print" aria-hidden="true"></i> Print</button> --}}
      </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Stuff Payment</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPaymentModal" data-backdrop="static"><i class="fa fa-fw fa-money" aria-hidden="true"></i> Add Payment</button>
            {{-- add stuff payment modal--}}
              <!-- Modal -->
              <div class="modal fade" id="addPaymentModal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Add Stuff Payment</h4>
                    </div>
                    <div class="modal-body">
                      <!-- form start -->
                      {!! Form::open(['route' => 'stuffs.payment', 'method' => 'POST']) !!}
                        <div class="form-group">
                          {!! Form::label('stuff_id', 'Suff:') !!}
                          <select name="stuff_id" id="stuff_id" class="form-control">
                            <option value="" selected="" disabled="">Select Stuff</option>
                            @foreach($stuffs as $stuff)
                              <option value="{{ $stuff->id }}">{{ $stuff->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          {!! Form::label('amount', 'Amount (Tk):') !!}
                          {!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Write Amount', 'step' => 'any', 'required' => '', 'min' => 0)) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                      {!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            {{-- add stuff payment modal--}}
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Payment Date</th>
                @permission('stuff-payment-edit')
                  <th>Action</th>
                @endpermission
              </tr>
            </thead>
            <tbody>
              @foreach($stuffpayments as $stuffpayment)
                <tr>
                  <td>{{ $stuffpayment->stuff->name }}</td>
                  <td>৳ {{ $stuffpayment->amount }}</td>
                  <td>{{ date('F d, Y h:i A', strtotime($stuffpayment->created_at)) }}</td>
                  @permission('stuff-payment-edit')
                    <td width="15%">
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editStuffPaymentModal{{ $stuffpayment->id }}" data-backdrop="static"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></button>
                      {{-- edit stuff modal--}}
                        <!-- Modal -->
                        <div class="modal fade" id="editStuffPaymentModal{{ $stuffpayment->id }}" role="dialog">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header modal-header-primary">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Edit Stuff Payment: <b>{{ $stuffpayment->stuff->name }}</b></h4>
                              </div>
                              <div class="modal-body">
                                <!-- form start -->
                                {!! Form::model($stuffpayment, ['route' => ['stuffs.payment.update', $stuffpayment->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                                  <div class="form-group">
                                    {!! Form::label('name', 'Stuff Name:') !!}
                                    {!! Form::text('name', $stuffpayment->stuff->name, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter New Category', 'disabled' => '')) !!}
                                  </div>
                                  <div class="form-group">
                                    {!! Form::label('amount', 'Amount (Tk):') !!}
                                    {!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Write Amount', 'step' => 'any', 'required' => '', 'min' => 0)) !!}
                                  </div>
                              </div>
                              <div class="modal-footer">
                                {!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}
                              {!! Form::close() !!}
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      {{-- edit stuff modal--}}

                      <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteStuffPaymentModal{{ $stuffpayment->id }}" data-backdrop="static"><i class="fa fa-fw fa-trash" aria-hidden="true"></i></button>
                      {{-- edit stuff modal--}}
                        <!-- Modal -->
                        <div class="modal fade" id="deleteStuffPaymentModal{{ $stuffpayment->id }}" role="dialog">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header modal-header-danger">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Delete Confirmation</h4>
                              </div>
                              <div class="modal-body">
                                <big>
                                  Are you sure to delete this payment?<br/><br/>
                                  Stuff: <b>{{ $stuffpayment->stuff->name }}</b><br/>
                                  Amount: <b>৳ {{ $stuffpayment->amount }}/-</b><br/>
                                  Date: <b>{{ date('F d, Y h:i A', strtotime($stuffpayment->created_at)) }}</b>
                                </big>
                              </div>
                              <div class="modal-footer">
                                {!! Form::model($stuffpayment, ['route' => ['stuffs.payment.destroy', $stuffpayment->id], 'method' => 'DELETE']) !!}
                                  <button type="submit" class="btn btn-danger">Delete</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                {!! Form::close() !!}
                              </div>
                            </div>
                          </div>
                        </div>
                      {{-- edit stuff modal--}}

                    </td>
                  @endpermission
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          {{ $stuffpayments->links() }}
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"> Add Stuff</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addStuffModal" data-backdrop="static"><i class="fa fa-fw fa-user-plus" aria-hidden="true"></i> Add Stuff</button>
            {{-- add stuff modal--}}
              <!-- Modal -->
              <div class="modal fade" id="addStuffModal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-success">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Add Stuff</h4>
                    </div>
                    <div class="modal-body">
                      <!-- form start -->
                      {!! Form::open(['route' => 'stuffs.store', 'method' => 'POST']) !!}
                        <div class="form-group">
                          {!! Form::label('name', 'Stuff Name:') !!}
                          {!! Form::text('name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter Stuff Name')) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                      {!! Form::submit('Submit', array('class' => 'btn btn-success')) !!}
                    {!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            {{-- add stuff modal--}}
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php
                $i = 1;
              @endphp
              @foreach($stuffs as $stuff)
              <tr>
                <td>{{ $i }}</td>
                <td>{{ $stuff->name }}</td>
                <td width="15%">
                  <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editStuffModal{{ $stuff->id }}" data-backdrop="static"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></button>
                  {{-- add stuff modal--}}
                    <!-- Modal -->
                    <div class="modal fade" id="editStuffModal{{ $stuff->id }}" role="dialog">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header modal-header-success">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Stuff: <b>{{ $stuff->name }}</b></h4>
                          </div>
                          <div class="modal-body">
                            <!-- form start -->
                            {!! Form::model($stuff, ['route' => ['stuffs.update', $stuff->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                              <div class="form-group">
                                {!! Form::label('name', 'Stuff Name:') !!}
                                {!! Form::text('name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter Stuff Name')) !!}
                              </div>
                          </div>
                          <div class="modal-footer">
                            {!! Form::submit('Submit', array('class' => 'btn btn-success')) !!}
                          {!! Form::close() !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  {{-- add stuff modal--}}
                </td>
              </tr>
              @php
                $i++;
              @endphp
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
      </div>
    </div>
  </div>
@stop


@section('js')

<script type="text/javascript">
  // $(document).ready(function(){
  //   $("#category_id_store").change(function(){
  //     $.get(window.location.protocol + "//" + window.location.host + "/categories/getcategoryunit/" + $(this).val(), function(data, status){
  //         //console.log("Data: " + data + "\nStatus: " + status);
  //         $("#unittostore").text(data);
  //     });
  //     $.get(window.location.protocol + "//" + window.location.host + "/stocks/getcategorymax/" + $(this).val(), function(data, status){
  //         console.log("Data: " + data + "\nStatus: " + status);
  //         $("#stockusagequantity").attr('max', data);
  //     });
  //   });
  // }); 
</script>

{{-- print code --}}
<script type="text/javascript">
  // document.getElementById("printBtn").onclick = function () {
  //     printElement(document.getElementById("printTable"));
  // }
  // function printElement(elem) {
  //     var domClone = elem.cloneNode(true);
  //     var $printSection = document.getElementById("printSection");
  //     if (!$printSection) {
  //         var $printSection = document.createElement("div");
  //         $printSection.id = "printSection";
  //         document.body.appendChild($printSection);
  //     }
  //     $printSection.innerHTML = "";
  //     $printSection.appendChild(domClone);
  //     window.print();
  // }
</script>
{{-- print code --}}

@stop