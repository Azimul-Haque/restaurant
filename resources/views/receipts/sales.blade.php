@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Receipts')

@section('css')
@stop

@section('content_header')
  <h1>
    Sales: Item Wise
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
      <table class="table table-condensed" id="datatable-itemwise">
        <thead>
          <tr>
            <th>Date</th>
            <th>Sales</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sales as $sale)
          <tr>
            <td>{{ date('l, F d, Y', strtotime($sale->created_at)) }}</td>
            <td>{{ $sale->totalsale }}</td>
            <td>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#showModal{{ date('Y-m-d', strtotime($sale->created_at)) }}" data-backdrop="static"><i class="fa fa-eye" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              <div id="printModal{{ date('Y-m-d', strtotime($sale->created_at)) }}" style="float: left">
              <div class="modal fade" id="showModal{{ date('Y-m-d', strtotime($sale->created_at)) }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-success">
                      <button type="button" class="close noPrint" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><b>Queen Island</b> Kitchen | Sales | {{ date('F d, Y', strtotime($sale->created_at)) }} </h4>
                    </div>
                    <div class="modal-body tableModalBody">
                      @foreach($details as $detail)
                        @if(date('F d, Y', strtotime($sale->created_at)) == date('F d, Y', strtotime($detail->created_at)))
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Item Name</th>
                                  <th>Qty</th>
                                  <th>Gross Price</th>
                                </tr>
                              </thead>
                              <tbody id="receiptItemsTr{{ date('Y-m-d', strtotime($detail->created_at)) }}"></tbody>
                            </table>
                          </div>
                          <script type="text/javascript">
                            var receipt = {!! json_encode($detail->receiptdata) !!};
                            var receipt = '['+receipt+']';
                            var receipt = JSON.parse(receipt);
                            //console.log(receipt);
                            merged = [];
                            for(i = 0; i < receipt.length; i++) {
                              var merged2 = receipt[i].items;
                              var merged = merged.concat(merged2);
                            }
                            //console.log(merged);
                            var mergedReceiptData = [];
                            merged.forEach(function(value) {
                              var existing = mergedReceiptData.filter(function(v, i) {
                                return v.name == value.name;
                              });
                              //console.log(value.name);
                              if (existing.length) {
                                var existingIndex = mergedReceiptData.indexOf(existing[0]);
                                mergedReceiptData[existingIndex].price = parseFloat(mergedReceiptData[existingIndex].price) + parseFloat(value.price);
                                mergedReceiptData[existingIndex].qty = parseFloat(mergedReceiptData[existingIndex].qty) + parseFloat(value.qty);
                              } else {
                                if ((typeof value.price == 'string') || (typeof value.qty == 'string'))
                                  value.price = parseFloat(value.price);
                                  value.qty = parseFloat(value.qty);
                                mergedReceiptData.push(value);
                              }
                            });

                            console.dir(mergedReceiptData);
                            var mergedreceipttable = '';
                            for(i = 0; i < mergedReceiptData.length; i++) {
                              mergedreceipttable += '<tr>';
                              mergedreceipttable += '  <td>' + mergedReceiptData[i].name + '</td>';
                              mergedreceipttable += '  <td>' + mergedReceiptData[i].qty + '</td>';
                              mergedreceipttable += '  <td>৳ ' + mergedReceiptData[i].price + '</td>';
                              mergedreceipttable += '</tr>';
                            }
                            mergedreceipttable += '<tr>';
                              mergedreceipttable += '  <td></td>';
                              mergedreceipttable += '  <td><b>Total Price</b></td>';
                              mergedreceipttable += '  <td><b>৳ ' + {{ $sale->totalsale }} + '</b></td>';
                            mergedreceipttable += '</tr>';
                            document.getElementById('receiptItemsTr{{ date('Y-m-d', strtotime($detail->created_at)) }}').innerHTML = mergedreceipttable;
                          </script>
                        @endif
                      @endforeach
                    </div>
                    <div class="modal-footer noPrint tableModalFooter">
                      <a class="btn btn-sm btn-info" href="{{ route('sales.print', $sale->created_at) }}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> POS Print</a>
                      <button type="button" class="btn btn-sm btn-primary" id="printModalBtn{{ date('Y-m-d', strtotime($sale->created_at)) }}"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              {{-- show modal--}}
              {{-- print code --}}
              <script type="text/javascript">
                document.getElementById("printModalBtn{{ date('Y-m-d', strtotime($sale->created_at)) }}").onclick = function () {
                    printElement(document.getElementById("printModal{{ date('Y-m-d', strtotime($sale->created_at)) }}"));
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
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endpermission
@stop

@section('js')
  <script type="text/javascript">
  $(function () {
    //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
    $('#datatable-itemwise').DataTable({
      'paging'      : true,
      'pageLength'  : 20,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order': [[ 0, "desc" ]],
       columnDefs: [
              { targets: [0], type: 'date'}
       ]
    });
    $('#datatable-commodities_wrapper').removeClass( 'form-inline' );
  })
</script>
@stop