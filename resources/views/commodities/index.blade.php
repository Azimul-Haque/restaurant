@extends('adminlte::page')

@section('title', 'Restaurant ABC | Commodities')

@section('content_header')
    <h1>
      Commodities
      <div class="pull-right">
        <button class="btn btn-primary" id="printPage"><i class="fa fa-fw fa-print" aria-hidden="true"></i> Print</button>
      </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="table-responsive">
        <table class="table" id="datatable-commodities">
          <thead>
            <tr>
              <th>Category</th>
              <th>Quantity</th>
              <th>Submitted By</th>
              <th>Total</th>
              <th>Created At</th>
              <th class="noPrint">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($commodities as $commodity)
            <tr>
              <td>{{ $commodity->category->name }}</td>
              <td>{{ $commodity->quantity }} {{ $commodity->category->unit }}</td>
              <td>{{ $commodity->user->name }}</td>
              <td>
                <span class="badge @if($commodity->total <= 100) bg-light-blue @elseif(($commodity->total > 100) && ($commodity->total <= 500)) bg-green @elseif(($commodity->total > 500) && ($commodity->total <= 1000)) bg-yellow @elseif(($commodity->total > 1000) && ($commodity->total <= 10000)) bg-red @else bg-grey @endif" style="font-size: 14.5px;">৳ {{ $commodity->total }}</span>
              </td>
              <td>{{ date('F d, Y h:i A', strtotime($commodity->created_at)) }}</td>
              <td class="noPrint">
                <div class="tools">
                  {{-- edit modal--}}
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $commodity->id }}" data-backdrop="static"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                      <!-- Trigger the modal with a button -->
                      <!-- Modal -->
                      <div class="modal fade" id="editModal{{ $commodity->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                          {!! Form::model($commodity, ['route' => ['commodities.update', $commodity->id], 'method' => 'PUT']) !!}
                            <div class="modal-header modal-header-success">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Edit {{ $commodity->category->name }}</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                {!! Form::label('category_id', 'Category') !!}
                                <select class="form-control" name="category_id" required="" disabled="">
                                    <option value="" selected="" disabled="">Select Category</option>
                                  @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($commodity->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                {!! Form::label('quantity', 'Quantity:') !!}
                                <div class="input-group">
                                  {!! Form::number('quantity', null, array('class' => 'form-control', 'placeholder' => 'Write Quantity', 'step' => 'any', 'required' => '', 'min' => 0)) !!}
                                  <span class="input-group-addon" id="unittoedit">
                                    {{ $commodity->category->unit }}
                                  </span>
                                </div>
                              </div>
                              <div class="form-group">
                                {!! Form::label('total', 'Total Cost:') !!}
                                {!! Form::number('total', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Write Total Cost', 'min' => 0, 'step' => 'any')) !!}
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
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $commodity->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      <!-- Trigger the modal with a button -->
                      <!-- Modal -->
                      <div class="modal fade" id="deleteModal{{ $commodity->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header modal-header-danger">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Delete Confirmation</h4>
                            </div>
                            <div class="modal-body">
                              Delete this commodity?
                            </div>
                            <div class="modal-footer">
                              {!! Form::model($commodity, ['route' => ['commodities.destroy', $commodity->id], 'method' => 'DELETE']) !!}
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
          <h3 class="box-title">Add New Commodity</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['route' => 'commodities.store', 'method' => 'POST']) !!}
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
                {!! Form::number('quantity', null, array('class' => 'form-control', 'placeholder' => 'Write Quantity', 'step' => 'any', 'required' => '', 'min' => 0)) !!}
                <span class="input-group-addon" id="unittostore">Unit</span>
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('total', 'Total Cost:') !!}
              {!! Form::number('total', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Write Total Cost', 'min' => 0, 'step' => 'any')) !!}
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            {!! Form::submit('Add Commodity', array('class' => 'btn btn-success btn-block')) !!}
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

    $("#printPage").click(function(){
      window.print();
    });
  }); 
</script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script> -->
<script type="text/javascript">
  $(function () {
    //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
    $('#datatable-commodities').DataTable({
      'paging'      : true,
      'pageLength'  : 8,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order': [[ 4, "desc" ]],
       columnDefs: [
              { targets: [5], visible: true, searchable: false},
              { targets: '_all', visible: true, searchable: true },
              { targets: [4], type: 'date'}
       ]
    });
  })
</script>
@stop