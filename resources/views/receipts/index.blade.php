@extends('adminlte::page')

@section('title', 'Restaurant ABC | Receipts')

@section('css')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@stop

@section('content_header')
  <h1>
    Receipts Management
  </h1>
@stop

@section('content')
    @permission('receipt-crud')
  {{-- @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
  @endif --}}
  <div class="table-responsive">
    <table class="table table-condensed" id="datatable-recepts">
      <thead>
        <tr>
          <th>No</th>
          <th>Receipt No</th>
          <th>Total</th>
          <th>Created at</th>
          <th width="280px">Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($data as $key => $receipt)
        <tr>
          <td>{{ ++$i }}</td>
          <td><a class="link bold" style="cursor: pointer;" data-toggle="modal" data-target="#showModal{{ $receipt->id }}" data-backdrop="static">{{ $receipt->receiptno }}</a></td>
          <td>{{ $receipt->total }}</td>
          <td>
            {{ date('F d, Y h:i A', strtotime($receipt->created_at)) }}
          </td>
          <td>
            {{-- show modal--}}
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#showModal{{ $receipt->id }}" data-backdrop="static"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <!-- Trigger the modal with a button -->
                <div id="printModal{{ $receipt->id }}" style="float: left">
                <div class="modal fade showModal{{ $receipt->id }}" id="showModal{{ $receipt->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-success">
                        <button type="button" class="close noPrint" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>Queen Island</b> Kitchen | Receipt no: <b>{{ $receipt->receiptno }}</b></h4>
                      </div>
                      <div class="modal-body tableModalBody">
                        <div style="float: right; font-size: 15px;" id="modalDateTimeDiv{{ $receipt->id }}"><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($receipt->created_at)) }}    <i class="fa fa-clock-o"></i> {{ date('h:i:s A', strtotime($receipt->created_at)) }}</div><br><br/>
                        <div class="table-responsive">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                              </tr>
                            </thead>
                            <tbody id="receiptItemsTr{{ $receipt->receiptno }}"></tbody>
                          </table>
                        </div>
                        <script type="text/javascript">
                          var receipt = JSON.parse({!! json_encode($receipt->receiptdata) !!});
                          //console.log(receipt.items);
                          var receipttable = '';
                          for(i = 0; i < receipt.items.length; i++) {
                            receipttable += '<tr>';
                            receipttable += '  <td>' + receipt.items[i].name + '</td>';
                            receipttable += '  <td>' + receipt.items[i].qty + '</td>';
                            receipttable += '  <td>৳ ' + receipt.items[i].price + '</td>';
                            receipttable += '</tr>';
                          }
                          receipttable += '<tr>';
                            receipttable += '  <td></td>';
                            receipttable += '  <td><b>Total Price</b></td>';
                            receipttable += '  <td><b>৳ ' + {{ $receipt->total }} + '</b></td>';
                          receipttable += '</tr>';
                          document.getElementById('receiptItemsTr{{ $receipt->receiptno }}').innerHTML = receipttable;
                        </script>
                      </div>
                      <div class="modal-footer noPrint tableModalFooter">
                        <button type="button" class="btn btn-sm btn-primary" id="printModalBtn{{ $receipt->id }}"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
            {{-- show modal--}}
            {{-- print code --}}
            <script type="text/javascript">
              document.getElementById("printModalBtn{{ $receipt->id }}").onclick = function () {
                    printElement(document.getElementById("printModal{{ $receipt->id }}"));
                }
                function printElement(elem) {
                    var domClone = elem.cloneNode(true);
                    document.getElementById('modalDateTimeDiv{{ $receipt->id }}').style.float = 'left';
                    
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
            <a class="btn btn-primary btn-sm" href="{{ route('receipts.edit',$receipt->id) }}">
              <i class="fa fa-pencil"></i>
            </a>
            {{-- delete modal--}}
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $receipt->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <!-- Trigger the modal with a button -->
                <!-- Modal -->
                <div class="modal fade" id="deleteModal{{ $receipt->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete confirmation</h4>
                      </div>
                      <div class="modal-body">
                        Delete receipt <b>{{ $receipt->receiptno }}</b>?
                      </div>
                      <div class="modal-footer">
                        {!! Form::model($receipt, ['route' => ['receipts.destroy', $receipt->id], 'method' => 'DELETE']) !!}
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
  {!! $data->render() !!}
    @endpermission
@stop

@section('js')
  <script type="text/javascript">
    $(function () {
      $('#datatable-receptssss').DataTable({
        'paging'      : true,
        'pageLength'  : 7,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
      });
    })
  </script>
@stop