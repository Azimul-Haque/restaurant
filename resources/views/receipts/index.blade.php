@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Receipts')

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
  <div class="row">
    <div class="col-md-8">
      <div class="table-responsive">
        <table class="table table-condensed" id="datatable-recepts">
          <thead>
            <tr>
              <th>No</th>
              <th>Receipt No</th>
              <th>QT</th>
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
              <td>{{ $receipt->customqty }}</td>
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
                            </div><br/>
                            <div>QT: <b>{{ $receipt->customqty}}</b></div>
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
                {{-- print code --}}
                {{-- <a class="btn btn-primary btn-sm" href="{{ route('receipts.edit',$receipt->id) }}">
                  <i class="fa fa-pencil"></i>
                </a> --}}
                @permission('receipt-delete')
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
                @endpermission
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>  
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-search"></i>
          <h3 class="box-title">Search Receipt</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <label for="receiptno">Receipt ID:</label>
            <input type="text" class="form-control" id="receiptno" placeholder="Enter Receipt ID" required="" autocomplete="off">
          </div>
          <button class="btn btn-primary" id="search_receipt" data-toggle="modal" data-target="#searchModal" data-backdrop="static"><i class="fa fa-fw fa-search" aria-hidden="true"></i> Search Receipt</button>
          <div id="printSearchModal">
            <div class="modal fade" id="searchModal" role="dialog">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header modal-header-success">
                  <h4 class="modal-title"><i class="fa fa-fw fa-search"></i> Search Result</h4>
                </div>
                <div class="modal-body">
                  <div style="font-size: 20px;">Search result for: 
                  <b><span id="search_receipt_no"></span></b></div><br/>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Item Name</th>
                          <th>Qty</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody id="searchModalItemsTr"></tbody>
                    </table>
                  </div><br/>
                  <div id="search_receipt_customqty"></div>
                </div>
                <div class="modal-footer noPrint">
                  <a href="" id="printPosSearchBtn" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> POS Print</a>
                  <button type="button" class="btn btn-sm btn-primary" id="printSearchBtn"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                  <button type="button" class="btn btn-default" id="clearSearchModalData" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
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
        'search_receipt'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
      });
    })
  </script>
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
        $('#printPosSearchBtn').attr('href', window.location.protocol + "//" + window.location.host + '/receipt/print/' +$('#receiptno').val());
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
                  document.getElementById('search_receipt_customqty').innerHTML = 'QT: <b>' + data.customqty + '</b>';
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