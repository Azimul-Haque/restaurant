@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | QIK Usage')

@section('content_header')
    <h1>
      QIK Usages
      <div class="pull-right">
        {{-- <button class="btn btn-primary" id="printBtn"><i class="fa fa-fw fa-print" aria-hidden="true"></i> Print</button> --}}
      </div>
  </h1>
@stop

@section('content')
  <div class="table-responsive" id="printTable">
    <table class="table" id="datatable-dailyusage">
      <thead>
        <tr>
          <th>Category</th>
          <th>Quantity</th>
          <th>Updated At</th>
          <th class="noPrint">Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($usages as $usage)
        <tr>
          <td>{{ $usage->qikstock->name }}</td>
          <td>{{ $usage->quantity }} {{ $usage->unit }}</td>
          <td>{{ date('F d, Y h:i A', strtotime($usage->updated_at)) }}</td>
          <td class="noPrint">
            @permission('usage-crud')
            <div class="tools">
              {{-- delete modal--}}
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $usage->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
                  <!-- Trigger the modal with a button -->
                  <!-- Modal -->
                  <div class="modal fade" id="deleteModal{{ $usage->id }}" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Delete Confirmation</h4>
                        </div>
                        <div class="modal-body">
                          Delete this Usage?
                        </div>
                        <div class="modal-footer">
                          {!! Form::model($usage, ['route' => ['usages.destroy', $usage->id], 'method' => 'DELETE']) !!}
                              <button type="submit" class="btn btn-danger">Delete</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                  </div>
              {{-- delete modal--}}
            </div>
            @endpermission
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@stop


@section('js')
  <script type="text/javascript">
    $(function () {
      $('#datatable-dailyusage').DataTable({
        'paging'      : true,
        'pageLength'  : 20,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'order': [[ 3, "desc" ]],
        columnDefs: [
              { targets: [4], visible: true, searchable: false},
              { targets: '_all', visible: true, searchable: true },
              { targets: [3], type: 'date'}
        ]
      });
      $('#datatable-dailyusage_wrapper').removeClass( 'form-inline' );
    })
  </script>
  {{-- print code --}}
  <script type="text/javascript">
    // document.getElementById("printBtn").onclick = function () {
    //     printElement(document.getElementById("printTable"));
    // }
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