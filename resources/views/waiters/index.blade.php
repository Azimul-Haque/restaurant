@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Waiters')

@section('css')
@stop

@section('content_header')
  <h1>
    <i class="fa fa-fw fa-male" aria-hidden="true"></i> Waiter Management
    <div class="pull-right">
      <button class="btn btn-warning" data-toggle="modal" data-target="#addWaiterModal" data-backdrop="static"id=""><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add New Waiter</button>
      <button class="btn btn-primary" id="printBtn"><i class="fa fa-fw fa-print" aria-hidden="true"></i> Print</button>
    </div>
  </h1>
@stop

@section('content')
    <div class="table-responsive" id="printTable">
      <table class="table table-condensed" id="datatable-members">
        <thead>
          <tr>
            <th>Name</th>
            <th>Total Orders</th>
            <th>Total Points</th>
            <th>Avarage</th>
            <th class="noPrint">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($waiters as $waiter)
          <tr>
            <td>{{ $waiter->name }}</td>
            <td>{{ $waiter->order }}</td>
            <td>{{ $waiter->point }}</td>
            @php
              if($waiter->order < 1) {
                $waiter->order = 1;
              }
            @endphp
            <td>{{ number_format((float)($waiter->point / $waiter->order), 2, '.', '') }}</td>
            <td class="noPrint">
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editWaiterModal{{ $waiter->id }}" data-backdrop="static"><i class="fa fa-pencil" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              {{-- edit modal--}}
              <div class="modal fade" id="editWaiterModal{{ $waiter->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-success">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Add Points To <b>{{ $waiter->name }}</b></h4>
                    </div>
                    {!! Form::model($waiter, ['route' => ['waiters.update', $waiter->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                    <div class="modal-body">
                          <div class="form-group">
                            {!! Form::label('newpoint', 'Add New Points:') !!}
                            {!! Form::number('newpoint', null, array('class' => 'form-control', 'placeholder' => 'Write Points', 'step' => 'any', 'required' => '', 'min' => 0, 'max' => 5)) !!}
                          </div>
                    </div>
                    <div class="modal-footer">
                          {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
              {{-- edit modal--}}

              {{-- delete modal--}}
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $waiter->id }}" data-backdrop="static" disabled=""><i class="fa fa-trash" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              <!-- Modal -->
              <div class="modal fade" id="deleteModal{{ $waiter->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete Confirmation</h4>
                    </div>
                    <div class="modal-body">
                      Delete this member?
                    </div>
                    <div class="modal-footer">
                      {!! Form::model($waiter, ['route' => ['waiters.destroy', $waiter->id], 'method' => 'DELETE']) !!}
                          <button type="submit" class="btn btn-danger">Delete</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
              {{-- delete modal--}}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Add Waiter Modal -->
    <!-- Add Waiter Modal -->
    <div class="modal fade" id="addWaiterModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-warning">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add New Waiter</h4>
          </div>
          {!! Form::open(['route' => 'waiters.store', 'method' => 'POST']) !!}
          <div class="modal-body">
                <div class="form-group">
                  {!! Form::label('name', 'Name') !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write Name', 'required' => '')) !!}
                </div>
          </div>
          <div class="modal-footer">
                {!! Form::submit('Add Waiter', array('class' => 'btn btn-success')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Add Waiter Modal -->
    <!-- Add Waiter Modal -->
@stop

@section('js')
  <script type="text/javascript">
  $(function () {
    //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
    $('#datatable-members').DataTable({
      'paging'      : true,
      'pageLength'  : 8,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order': [[ 5, "desc" ]],
       columnDefs: [
              { targets: [5], type: 'date'}
       ]
    });
    $('#datatable-members_wrapper').removeClass( 'form-inline' );
  })
</script>

{{-- print code --}}
<script type="text/javascript">
  document.getElementById("printBtn").onclick = function () {
      printElement(document.getElementById("printTable"));
  }
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