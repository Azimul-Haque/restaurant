@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | QIK Stocks')

@section('content_header')
    <h1>
      QIK Stocks
      <div class="pull-right">
        {{-- <button class="btn btn-primary" id="printBtn"><i class="fa fa-fw fa-print" aria-hidden="true"></i> Print</button> --}}
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal" data-backdrop="static"><i class="fa fa-plus" aria-hidden="true"></i> Add QIK Stock</button>
      </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="table-responsive" id="printTable">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>Item Name</th>
              <th>Quantity</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th class="noPrint">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($stocks as $stock)
            <tr>
              <td>{{ $stock->name }}</td>
              <td>{{ $stock->quantity }} {{ $stock->unit }}</td>
              <td>{{ date('F d, Y h:i A', strtotime($stock->created_at)) }}</td>
              <td>{{ date('F d, Y h:i A', strtotime($stock->updated_at)) }}</td>
              @permission('stock-edit')
              <td class="noPrint">
                <div class="tools">
                  {{-- edit modal--}}
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $stock->id }}" data-backdrop="static"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                      <!-- Trigger the modal with a button -->
                      <!-- Modal -->
                      <div class="modal fade" id="editModal{{ $stock->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                          {!! Form::model($stock, ['route' => ['qikstocks.update', $stock->id], 'method' => 'PUT']) !!}
                            <div class="modal-header modal-header-success">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Edit {{ $stock->name }}</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                {!! Form::label('name', 'Item Name') !!}
                                {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write QIK Stock Name', 'required' => '')) !!}
                              </div>
                              <div class="form-group">
                                {!! Form::label('unit', 'Stock Unit:') !!}
                                <select id="unit" name="unit" class="form-control" required="">
                                  <option value="" selected="" disabled="">Select the unit</option>
                                  <option value="Piece" @if($stock->unit == 'Piece') selected="" @endif>Piece</option>
                                  <option value="KG" @if($stock->unit == 'KG') selected="" @endif>KG</option>
                                  <option value="Litre" @if($stock->unit == 'Litre') selected="" @endif>Litre</option>
                                  <option value="Number" @if($stock->unit == 'Number') selected="" @endif>Number</option>
                                  <option value="Packet" @if($stock->unit == 'Packet') selected="" @endif>Packet</option>
                                  <option value="Dozen" @if($stock->unit == 'Dozen') selected="" @endif>Dozen</option>
                                  <option value="Can" @if($stock->unit == 'Can') selected="" @endif>Can</option>
                                  <option value="Bottle" @if($stock->unit == 'Bottle') selected="" @endif>Bottle</option>
                                  <option value="N/A" @if($stock->unit == 'N/A') selected="" @endif>N/A</option>
                                </select>
                              </div>
                              <div class="form-group">
                                {!! Form::label('quantity', 'Quantity:') !!}
                                {!! Form::number('quantity', null, array('class' => 'form-control', 'placeholder' => 'Write Quantity', 'step' => 'any', 'required' => '')) !!}
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Save</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>
                          {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                  {{-- edit modal--}}

                </div>
              </td>
              @endpermission
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-success noPrint">
        <div class="box-header with-border">
          <h3 class="box-title">QIK Stock Usage</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['route' => 'qikstocks.storeusage', 'method' => 'POST']) !!}
          <div class="box-body">
            <div class="form-group">
              {!! Form::label('qikstock_id', 'Qik Stock Item') !!}
              <select class="form-control" name="qikstock_id" id="qikstock_id_store" required="">
                  <option value="" selected="" disabled="">Select Category</option>
                @foreach($stocks as $stock)
                  <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              {!! Form::label('quantity', 'Quantity:') !!}
              <div class="input-group">
                {!! Form::number('quantity', null, array('class' => 'form-control', 'placeholder' => 'Write Quantity', 'step' => 'any', 'min' => 0, 'required' => '', 'id' => 'stockusagequantity')) !!}
                <span class="input-group-addon" id="unittostore">Unit</span>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            {!! Form::submit('Add QIK Usage', array('class' => 'btn btn-success btn-block')) !!}
          </div>
        {!! Form::close() !!}
      </div>
    </div>

    {{-- add modal--}}
    <!-- Trigger the modal with a button -->
    <!-- Modal -->
    <div class="modal fade" id="addModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
        {!! Form::open(['route' => 'qikstocks.store', 'method' => 'POST']) !!}
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add QIK Stock</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              {!! Form::label('name', 'Item Name') !!}
              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write QIK Stock Name', 'required' => '')) !!}
            </div>
            <div class="form-group">
              {!! Form::label('unit', 'Stock Unit:') !!}
              <select id="unit" name="unit" class="form-control" required="">
                <option value="" selected="" disabled="">Select the unit</option>
                <option value="Piece">Piece</option>
                <option value="KG">KG</option>
                <option value="Litre">Litre</option>
                <option value="Number">Number</option>
                <option value="Packet">Packet</option>
                <option value="Dozen">Dozen</option>
                <option value="Can">Can</option>
                <option value="Bottle">Bottle</option>
                <option value="N/A">N/A</option>
              </select>
            </div>
            <div class="form-group">
              {!! Form::label('quantity', 'Quantity:') !!}
              {!! Form::number('quantity', null, array('class' => 'form-control', 'placeholder' => 'Write Quantity', 'step' => 'any', 'required' => '')) !!}
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        {!! Form::close() !!}
        </div>
      </div>
    </div>
    {{-- add modal--}}
  </div>
@stop


@section('js')

<script type="text/javascript">
  $(document).ready(function(){
    $("#qikstock_id_store").change(function(){
      $.get(window.location.protocol + "//" + window.location.host + "/qikstocks/getqikstockunit/" + $(this).val(), function(data, status){
          //console.log("Data: " + data + "\nStatus: " + status);
          $("#unittostore").text(data);
      });
      $.get(window.location.protocol + "//" + window.location.host + "/qikstocks/getqikstockmax/" + $(this).val(), function(data, status){
          console.log("Data: " + data + "\nStatus: " + status);
          $("#stockusagequantity").attr('max', data);
      });
    });
  }); 
</script>

{{-- print code --}}
<script type="text/javascript">
  // document.getElementById("printBtn").onclick = function () {
  //     printElement(document.getElementById("printTable"));
  // }
  function printElement(elem) {
      var domClone = elem.cloneNode(true);
      var $printSection = document.getElementById("printSection");
      if (!$printSection) {
          var $printSection = document.createElement("div");
          $printSection.id = "printSection";
          document.body.appendChild($printSection);
      }
      $printSection.innerHTML = "";
      $printSection.appendChild(domClone);
      window.print();
  }
</script>
{{-- print code --}}

@stop