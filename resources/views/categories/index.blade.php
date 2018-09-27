@extends('adminlte::page')

@section('title', 'Restaurant ABC | Categories')

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
          <table class="table">
            <tbody>
              <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Unit</th>
                <th style="width: 40px">Action</th>
              </tr>
            @foreach ($categories as $category)
              <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->unit }}</td>
                <td>
                  
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
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Source List</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addSourceModal" data-backdrop="static"><i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i> Add Source</button>
            {{-- add category modal--}}
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
            {{-- add category modal--}}
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
              </tr>
            @foreach ($sources as $source)
              <tr>
                <td>{{ $source->id }}</td>
                <td>{{ $source->name }}</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
@stop


@section('js')

@stop