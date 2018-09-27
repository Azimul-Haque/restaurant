@extends('adminlte::page')

@section('title', 'Restaurant ABC | Stocks')

@section('content_header')
    <h1>
      Stocks
      <div class="pull-right">
        <button class="btn btn-primary" id="printBtn"><i class="fa fa-fw fa-print" aria-hidden="true"></i> Print</button>
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
              <th>Category</th>
              <th>Quantity</th>
              <th>Submitted By</th>
              <th>Created At</th>
              <th class="noPrint">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($stocks as $stock)
            <tr>
              <td>{{ $stock->category->name }}</td>
              <td>{{ $stock->quantity }} {{ $stock->category->unit }}</td>
              <td>{{ $stock->user->name }}</td>
              <td>{{ date('F d, Y h:i A', strtotime($stock->created_at)) }}</td>
              <td class="noPrint">
                <div class="tools">
                  {{-- edit modal--}}
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $stock->id }}" data-backdrop="static"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                      <!-- Trigger the modal with a button -->
                      <!-- Modal -->
                      <div class="modal fade" id="editModal{{ $stock->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                          {!! Form::model($stock, ['route' => ['stocks.update', $stock->id], 'method' => 'PUT']) !!}
                            <div class="modal-header modal-header-success">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Edit {{ $stock->category->name }}</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                {!! Form::label('category_id', 'Category') !!}
                                <select class="form-control" name="category_id" required="" disabled="">
                                    <option value="" selected="" disabled="">Select Category</option>
                                  @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($stock->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                {!! Form::label('quantity', 'Quantity:') !!}
                                <div class="input-group">
                                  {!! Form::number('quantity', null, array('class' => 'form-control', 'placeholder' => 'Write Quantity', 'step' => 'any')) !!}
                                  <span class="input-group-addon" id="unittoedit">
                                    {{ $stock->category->unit }}
                                  </span>
                                </div>
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
                  {{-- delete modal--}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $stock->id }}" data-backdrop="static" disabled=""><i class="fa fa-trash" aria-hidden="true"></i></button>
                      <!-- Trigger the modal with a button -->
                      <!-- Modal -->
                      <div class="modal fade" id="deleteModal{{ $stock->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header modal-header-danger">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Delete Confirmation</h4>
                            </div>
                            <div class="modal-body">
                              Delete this Stock?
                            </div>
                            <div class="modal-footer">
                              {!! Form::model($stock, ['route' => ['stocks.destroy', $stock->id], 'method' => 'DELETE']) !!}
                                  <button type="submit" class="btn btn-danger">Delete</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                  {{-- delete modal--}}
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-success noPrint">
        <div class="box-header with-border">
          <h3 class="box-title">Stock Usage</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['route' => 'stocks.store', 'method' => 'POST']) !!}
          <div class="box-body">
            <div class="form-group">
              {!! Form::label('category_id', 'Category') !!}
              <select class="form-control" name="category_id" id="category_id_store" required="">
                  <option value="" selected="" disabled="">Select Category</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              {!! Form::label('quantity', 'Quantity:') !!}
              <div class="input-group">
                {!! Form::number('quantity', null, array('class' => 'form-control', 'placeholder' => 'Write Quantity', 'step' => 'any', 'min' => 0, 'required' => '')) !!}
                <span class="input-group-addon" id="unittostore">Unit</span>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            {!! Form::submit('Add Stock', array('class' => 'btn btn-success btn-block')) !!}
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@stop


@section('js')

<script type="text/javascript">
  $(document).ready(function(){
    $("#category_id_store").change(function(){
      $.get(window.location.protocol + "//" + window.location.host + "/categories/getcategoryunit/" + $(this).val(), function(data, status){
          //console.log("Data: " + data + "\nStatus: " + status);
          $("#unittostore").text(data);
      });     
    });
  }); 
</script>

{{-- print code --}}
<script type="text/javascript">
  document.getElementById("printBtn").onclick = function () {
      printElement(document.getElementById("printTable"));
  }
  function printElement(elem) {
      var domClone = elem.cloneNode(true);
      
      $('#datatable-commodities_wrapper').removeClass( 'form-inline' );
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