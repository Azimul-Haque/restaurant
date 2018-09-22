@extends('adminlte::page')

@section('title', 'Restaurant ABC | Categories')

@section('content_header')
    <h1>
      Categories
      <div class="pull-right">
        
      </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Categories List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table">
            <tbody>
              <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Unit</th>
                <th style="width: 40px">Used</th>
              </tr>
            @foreach ($categories as $category)
              <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->unit }}</td>
                <td>
                  <span class="badge bg-light-blue">30%</span>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>


    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Add New Category</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['route' => 'categories.store', 'method' => 'POST']) !!}
          <div class="box-body">
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
              </select>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            {!! Form::submit('Add Category', array('class' => 'btn btn-success btn-block')) !!}
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@stop


@section('js')

@stop