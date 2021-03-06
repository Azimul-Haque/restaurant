@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Categories')

@section('css')
  <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
@stop

@section('content_header')
  <h1>
    Categories &amp; Sources
    <div class="pull-right">
      
    </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-5">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Categories List</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#addCategoryModal" data-backdrop="static"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Category</button>
            {{-- add category modal--}}
              <!-- Modal -->
              <div class="modal fade" id="addCategoryModal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-info">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Add Category</h4>
                    </div>
                    <div class="modal-body">
                      <!-- form start -->
                      {!! Form::open(['route' => 'categories.store', 'method' => 'POST']) !!}
                        <div class="form-group">
                          {!! Form::label('name', 'Category Name:') !!}
                          {!! Form::text('name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter New Category')) !!}
                        </div>
                        <div class="form-group">
                          {!! Form::label('unit', 'Category Unit:') !!}
                          <select id="unit" name="unit" class="form-control" required="">
                            <option value="" selected="" disabled="">Select the unit</option>
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
                    </div>
                    <div class="modal-footer">
                      {!! Form::submit('Add Category', array('class' => 'btn btn-info')) !!}
                    {!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            {{-- add category modal--}}
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table" id="datatable-categories-list">
            <thead>
              <tr>
                <th>Name</th>
                <th>Unit</th>
                <th style="width: 40px">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
              <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->unit }}</td>
                <td>
                  <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editCategoryModal{{ $category->id }}" data-backdrop="static"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></button>
                  {{-- edit category modal--}}
                    <!-- Modal -->
                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" role="dialog">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header modal-header-info">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Category</h4>
                          </div>
                          <div class="modal-body">
                            <!-- form start -->
                            {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                              <div class="form-group">
                                {!! Form::label('name', 'Category Name:') !!}
                                {!! Form::text('name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter New Category')) !!}
                              </div>
                              <div class="form-group">
                                {!! Form::label('unit', 'Category Unit:') !!}
                                <select id="unit" name="unit" class="form-control" required="">
                                  <option value="" selected="" disabled="">Select the unit</option>
                                  <option value="KG" @if($category->unit=='KG') selected="" @endif>KG</option>
                                  <option value="Litre" @if($category->unit=='Litre') selected="" @endif>Litre</option>
                                  <option value="Number" @if($category->unit=='Number') selected="" @endif>Number</option>
                                  <option value="Packet" @if($category->unit=='Packet') selected="" @endif>Packet</option>
                                  <option value="Dozen" @if($category->unit=='Dozen') selected="" @endif>Dozen</option>
                                  <option value="Can" @if($category->unit=='Can') selected="" @endif>Can</option>
                                  <option value="Bottle" @if($category->unit=='Bottle') selected="" @endif>Bottle</option>
                                  <option value="N/A" @if($category->unit=='N/A') selected="" @endif>N/A</option>
                                </select>
                              </div>
                          </div>
                          <div class="modal-footer">
                            {!! Form::submit('Save', array('class' => 'btn btn-info')) !!}
                            {!! Form::close() !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  {{-- edit category modal--}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>


    <div class="col-md-7">
      <div id="printTable">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Source List</h3>
            <div class="box-tools pull-right noPrint">
              <a class="btn btn-warning btn-sm" href="{{ route('reports.getallsourcepdf') }}"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Report Download</a>
              <a class="btn btn-primary btn-sm" href="{{ route('sources.print.normal') }}" target="_blank"><i class="fa fa-fw fa-print" aria-hidden="true"></i> POS Print</a>
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addSourceModal" data-backdrop="static"><i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i> Add Source</button>
              {{-- add source modal--}}
                <!-- Modal -->
                <div class="modal fade" id="addSourceModal" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-success">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Source</h4>
                      </div>
                      <div class="modal-body">
                        <!-- form start -->
                        {!! Form::open(['route' => 'sources.store', 'method' => 'POST']) !!}
                          <div class="form-group">
                            {!! Form::label('name', 'Source Name:') !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter New Source/ Store')) !!}
                          </div>
                      </div>
                      <div class="modal-footer">
                        {!! Form::submit('Add Source', array('class' => 'btn btn-success')) !!}
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
              {{-- add source modal--}}
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Total</th>
                  <th>Paid</th>
                  <th>Due</th>
                  <th class="noPrint">Action</th>
                </tr>
              @php 
                $i = 1; 
              @endphp
              @foreach ($sources as $source)
                <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $source->name }}</td>
                  <td>{{ $source->total }}</td>
                  <td>{{ $source->paid }}</td>
                  <td>{{ $source->due }}</td>
                  
                  <td class="noPrint">
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editSourceModal{{ $source->id }}" data-backdrop="static"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></button>
                    {{-- edit source modal--}}
                      <!-- Modal -->
                      <div class="modal fade" id="editSourceModal{{ $source->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header modal-header-success">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Edit Source</h4>
                            </div>
                            <div class="modal-body">
                              <!-- form start -->
                              {!! Form::model($source, ['route' => ['sources.update', $source->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                                <div class="form-group">
                                  {!! Form::label('name', 'Source Name:') !!}
                                  {!! Form::text('name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter New Source/ Store')) !!}
                                </div>
                                <div class="form-group">
                                  {!! Form::label('total', 'Total:') !!}
                                  <input type="text" name="total" id="sourcetotal{{ $source->id }}" placeholder='Total' class="form-control" value="{{ $source->total }}"
                                  @role('manager') readonly="" @endrole
                                  >
                                </div>
                                <div class="form-group">
                                  {!! Form::label('newpaid', 'Paid') !!}
                                  {!! Form::text('newpaid', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Paid', 'id' => 'sourcepaid'.$source->id)) !!}
                                </div>
                                <div class="form-group">
                                  {!! Form::label('due', 'Due:') !!}
                                  {!! Form::text('due', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Due', 'id' => 'sourcedue'.$source->id)) !!}
                                  {!! Form::hidden('due', null, ['id' => 'sourceduehidden'.$source->id]) !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                              {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                                                    {!! Form::close() !!}
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    {{-- edit source modal--}}
                  </td>
                </tr>
                <script type="text/javascript">
                  // $('#sourcetotal{{ $source->id }}').keyup(function() {
                  //   var sourcetotal = $('#sourcetotal{{ $source->id }}').val();
                  //   var sourcepaid = $('#sourcepaid{{ $source->id }}').val();
                  //   var sourcedue = sourcetotal - sourcepaid;
                  //   $('#sourcedue{{ $source->id }}').val(sourcedue);
                  // })
                  $('#sourcepaid{{ $source->id }}').keyup(function() {
                    var sourcedue = $('#sourceduehidden{{ $source->id }}').val();
                    var sourcepaid = $('#sourcepaid{{ $source->id }}').val();
                    var sourcedue = sourcedue - sourcepaid;
                    $('#sourcedue{{ $source->id }}').val(sourcedue);
                  })
                </script>
                @php 
                  $i++; 
                @endphp
              @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
@stop


@section('js')

<script type="text/javascript">
  $(function () {
    //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
    $('#datatable-categories-list').DataTable({
      'paging'      : true,
      'pageLength'  : 25,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order': [[ 0, "asc" ]]
    });
    $('#datatable-categories-list_wrapper').removeClass( 'form-inline' );
  })
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