<!-- TODO: Implement pagination (check data table in adminlte site) -->
@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Servicios &amp; Repuestos</h1>
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
          <h3 class="box-title">Lista de servicios &amp; repuestos</h3>

          <div class="box-tools">
            <a type="button" class="btn btn-sm btn-success" href="/cms/garages/create">
              <i class="fa fa-plus"></i>
              Nuevos Servicios &amp; Repuestos
            </a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tbody><tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>&nbsp;</th>
            </tr>
            @foreach ($data as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td class="float-right">
                  <form action="{{ action('CMS\BranchOfficesController@destroy', $row->id) }}" method="POST" onsubmit="return confirm('Está seguro que desea borrar los servicios & repuestos {{ $row->name }}')">
                    <a type="button" class="btn btn-sm btn-warning" href="/cms/garages/{{ $row->id }}/edit">
                      <i class="fa fa-edit"></i>
                    </a>
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
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