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
          <h3 class="box-title">Lista de contenidos</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tbody><tr>
              <th>Titulo</th>
              <th>&nbsp;</th>
            </tr>
            @foreach ($data as $row)
              <tr>
                <td>{{ $row->title }}</td>
                <td class="float-right">
                  <a type="button" class="btn btn-sm btn-warning" href="/cms/contents/{{ $row->id }}/edit">
                    <i class="fa fa-edit"></i>
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