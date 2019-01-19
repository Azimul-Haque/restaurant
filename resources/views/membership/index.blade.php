@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | Receipts')

@section('css')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/smscounter.js') }}"></script>
@stop

@section('content_header')
  <h1>
    <i class="fa fa-fw fa-address-book" aria-hidden="true"></i> Membership Management
    <div class="pull-right">
      <button class="btn btn-warning" data-toggle="modal" data-target="#addMemberModal" data-backdrop="static"id=""><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add New Member</button>
      <button class="btn btn-primary" id="printBtn"><i class="fa fa-fw fa-print" aria-hidden="true"></i> Print</button>
    </div>
  </h1>
@stop

@section('content')
    @permission('receipt-crud')
  {{-- @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
  @endif --}}
    <div class="table-responsive" id="printTable">
      <table class="table table-condensed" id="datatable-members">
        <thead>
          <tr>
            <th>Name</th>
            <th>Membership ID/Phone</th>
            <th>Points</th>
            <th>Awarded</th>
            <th>Last Awarded</th>
            <th>Member Since</th>
            <th class="noPrint">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($memberships as $membership)
          <tr>
            <td>
              {{ $membership->name }}
              @if($membership->type == 1)
                <span class="label label-success" style="font-size: 11px; cursor: pointer; padding: 3px;" title="{{ $membership->name }} is a VIP Member!"><i class="fa fa-diamond"></i> VIP</span>
              @endif
            </td>
            <td>{{ $membership->phone }}</td>
            <td>{{ $membership->point }}</td>
            <td>{{ $membership->awarded }}</td>
            <td>
              @if($membership->awarded > 0)
                {{ date('F d, Y', strtotime($membership->updated_at)) }}
              @else
                -
              @endif
            </td>
            <td>{{ date('F d, Y', strtotime($membership->created_at)) }}</td>
      
            <td class="noPrint">
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editMemberModal{{ $membership->id }}" data-backdrop="static" data-placement="top" title="মেম্বার সম্পাদনা করুন (পয়েন্ট যোগ করুন)"><i class="fa fa-pencil" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              {{-- edit modal--}}
              <div class="modal fade" id="editMemberModal{{ $membership->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-success">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Add Points To <b>{{ $membership->name }}</b></h4>
                    </div>
                    {!! Form::model($membership, ['route' => ['membership.update', $membership->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                    <div class="modal-body">
                          <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write Name', 'required' => '')) !!}
                          </div>
                          <div class="form-group">
                            {!! Form::label('phone', 'Mobile Number (11 Digits)') !!}
                            {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Write 11 Digit Mobile Number (Like 01700000000)', 'pattern' =>'\d*', 'required' => '', 'maxlength' => '11')) !!}
                          </div>
                          <div class="form-group">
                            {!! Form::label('type', 'Member Type:') !!}
                            <select name="type" class="form-control" id="type" required="">
                              <option value="" selected="" disabled="">Select Member Type</option>
                              <option value="0" @if($membership->type == 0) selected="" @endif>General Member</option>
                              <option value="1" @if($membership->type == 1) selected="" @endif>VIP Member</option>
                            </select>
                          </div>
                          <div class="form-group">
                            {!! Form::label('newpoint', 'Add Points:') !!}
                            {!! Form::number('newpoint', null, array('class' => 'form-control', 'placeholder' => 'Write Points', 'step' => 'any', 'required' => '', 'min' => 0)) !!}
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

              {{-- award modal--}}
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#awardMemberModal{{ $membership->id }}" data-backdrop="static" data-placement="top" title="পুরস্কার প্রদান করুন"><i class="fa fa-trophy" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              <!-- Modal -->
              <div class="modal fade" id="awardMemberModal{{ $membership->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Award Confirmation</h4>
                    </div>
                    <div class="modal-body">
                      Award This Member: <b>{{ $membership->name }}</b> ?
                    </div>
                    <div class="modal-footer">
                      {!! Form::model($membership, ['route' => ['membership.award', $membership->id], 'method' => 'PATCH']) !!}
                          <button type="submit" class="btn btn-primary">Award</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
              {{-- award modal--}}

              {{-- sms modal--}}
              <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#sendSMSModal{{ $membership->id }}" data-backdrop="static" data-placement="top" title="{{ $membership->name }}-কে SMS পাঠান"><i class="fa fa-envelope" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              <!-- Modal -->
              <div class="modal fade" id="sendSMSModal{{ $membership->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-warning">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> SMS Panel (Send a SMS to <b>{{ $membership->name }}</b>)</h4>
                    </div>
                    <div class="modal-body">
                      {!! Form::open(['route' => ['membership.singlesms', $membership->id], 'method' => 'POST']) !!}
                          <div class="form-group">
                            <label for="phone">Mobile Number: (Just write the 11 digit mobile number)</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $membership->phone }}" required="">
                          </div>
                          <div class="form-group">
                            <label for="singlemessage{{ $membership->id }}">Message:</label>
                            <textarea type="text" name="message" id="singlemessage{{ $membership->id }}" class="form-control textarea" required=""></textarea>
                          </div>
                          <table class="table">
                            <tr id="smstestresult{{ $membership->id }}">
                              <td>Encoding: <span class="encoding">GSM_7BIT</span></td>
                              <td>Length: <span class="length">0</span></td>
                              <td>SMS Cost: <span class="messages" id="smscount{{ $membership->id }}">0</span></td>
                              <td>Remaining: <span class="remaining">160</span></td>
                            </tr>
                          </table>
                          <input type="hidden" name="smscount" id="smscounthidden{{ $membership->id }}" required="">
                          <input type="hidden" name="membership_id" value="{{ $membership->id }}" required="">
                    </div>
                    <div class="modal-footer">
                          <button type="submit" class="btn btn-warning"><i class="fa fa-paper-plane"></i> Send SMS</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
              <script type="text/javascript">
                $('#singlemessage{{ $membership->id }}').countSms('#smstestresult{{ $membership->id }}');
                $('#singlemessage{{ $membership->id }}').keyup(function() {
                    $('#smscounthidden{{ $membership->id }}').val($('#smscount{{ $membership->id }}').text());
                });
              </script>
              {{-- sms modal--}}

              {{-- delete modal--}}
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $membership->id }}" data-backdrop="static" data-placement="top" title="মেম্বার মুছে দিন"><i class="fa fa-trash" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              <!-- Modal -->
              <div class="modal fade" id="deleteModal{{ $membership->id }}" role="dialog">
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
                      {!! Form::model($membership, ['route' => ['membership.destroy', $membership->id], 'method' => 'DELETE']) !!}
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

    <!-- Add Member Modal -->
    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-warning">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add New Member</h4>
          </div>
          {!! Form::open(['route' => 'membership.store', 'method' => 'POST']) !!}
          <div class="modal-body">
                <div class="form-group">
                  {!! Form::label('name', 'Name') !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write Name', 'required' => '')) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('phone', 'Mobile Number (11 Digits)') !!}
                  {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Write 11 Digit Mobile Number (Like 01700000000)', 'required' => '', 'pattern' =>'\d*', 'maxlength' => '11')) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('type', 'Member Type:') !!}
                  <select name="type" class="form-control" id="type" required="">
                    <option value="" selected="" disabled="">Select Member Type</option>
                    <option value="0">General Member</option>
                    <option value="1">VIP Member</option>
                  </select>
                </div>
                <div class="form-group">
                  {!! Form::label('point', 'Add Points:') !!}
                  {!! Form::number('point', null, array('class' => 'form-control', 'placeholder' => 'Write Points', 'step' => 'any', 'required' => '', 'min' => 0)) !!}
                </div>
          </div>
          <div class="modal-footer">
                {!! Form::submit('Add Member', array('class' => 'btn btn-success')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Add Member Modal -->
    <!-- Add Member Modal -->
    @endpermission
@stop

@section('js')
  <script>
    $(document).ready(function(){
      $('a[title]').tooltip();
      $('button[title]').tooltip();
      $('span[title]').tooltip();
    });
  </script>
  <script type="text/javascript">
  $(function () {
    //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
    $('#datatable-members').DataTable({
      'paging'      : true,
      'pageLength'  : 20,
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