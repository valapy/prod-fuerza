<!-- TODO: Implement pagination (check data table in adminlte site) -->
@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Contenido</h1>
@stop

@section('content')
  @if (isset($error))
    <div class="callout callout-danger">{{ $error }}</div>
  @elseif (isset($success))
    <div class="callout callout-success">{{ $success }}</div>
  @endif

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Lista de presupuestos</h3>
          <div class="box-tools pull-right">
            <form>
              <select name="office_id">
                <option value="0">Todas</option>
                @foreach ($offices as $row)
                  <option value="{{$row->id}}"<?=isset($_GET['office_id']) && $row->id==$_GET['office_id'] ? ' selected="selected"' : ''?>>{{ $row->name }}</option>
                @endforeach
              </select>
              <button type="submit">
                <span class="fa fa-search"></span>
              </button>
            </form>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tbody><tr>
              <th>Interesado</th>
              <th>Producto de interés</th>
              <th>Sucursal más cercana</th>
              <th>Estado</th>
              <th>&nbsp;</th>
            </tr>
            @foreach ($data as $row)
              <tr>
                <td>{{ $row->name }}</td>
                <td>{{ $row->product_of_interest }}</td>
                <td>{{ $row->office() != null ? $row->office()->name : '' }}</td>
                <td>{!! $row->displayStatusLabel() !!}</td>
                <td class="float-right">
                  <a type="button" class="btn btn-sm btn-warning" href="/cms/budgets/{{ $row->id }}">
                    <i class="fa fa-file-text-o"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
@stop