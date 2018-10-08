@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Deleted Receipts')

@section('css')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@stop

@section('content_header')
  <h1>
    Deleted Receipts
  </h1>
@stop

@section('content')
  @permission('receipt-delete')
  <div class="table-responsive">
    <table class="table table-condensed" id="datatable-recepts">
      <thead>
        <tr>
          <th>No</th>
          <th>Receipt No</th>
          <th>Total</th>
          <th>Discount (%)</th>
          <th>Discounted Total</th>
          <th>Created at</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($data as $key => $receipt)
        <tr>
          <td>{{ ++$i }}</td>
          <td><a class="link bold" style="cursor: pointer;" data-toggle="modal" data-target="#showModal{{ $receipt->id }}" data-backdrop="static">{{ $receipt->receiptno }}</a></td>
          <td>{{ $receipt->total }}</td>
          <td>{{ $receipt->discount }}%</td>
          <td>{{ $receipt->discounted_total }}</td>
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
                        <h4 class="modal-title"><b>Queen Island</b> Kitchen</h4>
                      </div>
                      <div class="modal-body tableModalBody">
                        <div style="float: left; font-size: 15px;">Receipt no: <b>{{ $receipt->receiptno }}</b></div>
                        <div style="float: right; font-size: 15px;"><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($receipt->created_at)) }}    <i class="fa fa-clock-o"></i> {{ date('h:i:s A', strtotime($receipt->created_at)) }}</div><br><br/>
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
                          receipttable += '<tr>';
                            receipttable += '  <td></td>';
                            receipttable += '  <td><b>Discount</b></td>';
                            receipttable += '  <td><b>' + {{ $receipt->discount }} + '%</b></td>';
                          receipttable += '</tr>';
                          receipttable += '<tr>';
                            receipttable += '  <td></td>';
                            receipttable += '  <td><b>Discounted Price</b></td>';
                            receipttable += '  <td><b>৳ ' + {{ $receipt->discounted_total }} + '</b></td>';
                          receipttable += '</tr>';
                          document.getElementById('receiptItemsTr{{ $receipt->receiptno }}').innerHTML = receipttable;
                        </script>
                      </div>
                      <div class="modal-footer noPrint tableModalFooter">
                        <a href="{{ route('receipt.print', $receipt->receiptno) }}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> POS Print</a>
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
    $(document).ready(function() {
      $('#search_receipt').attr('disabled', true);
      $('#receiptno').keyup(function() {
        if( !$.trim( $('#receiptno').val() ) == '' ) {
          $('#search_receipt').attr('disabled', false);
        } else {
          $('#search_receipt').attr('disabled', true);
        }
      });
      $('#clearSearchModalData').click(function() {
        //console.log('clicked');
        document.getElementById('searchModalItemsTr').innerHTML = '';
      });
      $('#search_receipt').click(function() {
        $('#search_receipt_no').text($('#receiptno').val());
        $.ajax({
             type: 'GET',
             url: window.location.protocol + "//" + window.location.host + '/receipt/search/' + $('#receiptno').val().trim(),
             data: [],
             success:function(data){
                if(data != '') {
                  var receipt = JSON.parse(data.receiptdata);
                  //console.log(data.total);
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
                    receipttable += '  <td><b>৳ ' + data.total + '</b></td>';
                    receipttable += '</tr>';
                    receipttable += '<tr>';
                    receipttable += '  <td></td>';
                    receipttable += '  <td><b>Discount</b></td>';
                    receipttable += '  <td><b>' + data.discount + '%</b></td>';
                    receipttable += '</tr>';
                    receipttable += '<tr>';
                    receipttable += '  <td></td>';
                    receipttable += '  <td><b>Discounted Price</b></td>';
                    receipttable += '  <td><b>৳ ' + data.discounted_total + '</b></td>';
                    receipttable += '</tr>';
                  document.getElementById('searchModalItemsTr').innerHTML = receipttable;
                } else {
                  document.getElementById('searchModalItemsTr').innerHTML = '<tr><td colspan="3"><center><h3>পাওয়া যায়নি!</h3></center></td></tr>';
                }
             },
              error: function() {
                document.getElementById('searchModalItemsTr').innerHTML = '<tr><td colspan="3"><center><h3>তথ্য দিতে ভুল হয়েছে</h3></center></td></tr>';
              }
          });
      })
    }); 
  </script>
  {{-- print code --}}
  <script type="text/javascript">
    document.getElementById("printSearchBtn").onclick = function () {
        printElement(document.getElementById("printSearchModal"));
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