<!-- TODO: Implement the form -->
@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Presupuestos</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/cms.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('js')
    <script type="text/javascript" src="/js/cms.js"></script>
    <script type="text/javascript">
      $('.change-status').on('click', function(){
        $(".status").val($(this).attr('data-value'));
        $('form').submit();
      })
    </script>
@stop

@section('content')
  @if ($errors->any())
    <div class="callout callout-danger">
      <h4>Ocurrieron los siguientes errores:</h4>
      <ul>
        @foreach ($errors->getBags() as $bag)
          @foreach($bag->toArray() as $key => $errors)
            <li>
              {{$key}}:
              <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach  
              </i;>
            </li>
          @endforeach  
        @endforeach
      </ul>
    </div>
  @elseif (isset($success))
    <div class="callout callout-success"><?=$success?></div>
  @endif

  <!-- form start -->
  <form role="form" method="POST" action="{{ action('CMS\BudgetsController@update', $data->id) }}" enctype="multipart/form-data">

    @csrf
    <input name="_method" type="hidden" value="PUT">
    <input class="status" name="status" type="hidden" value="{{ $data->status }}">

    <div class="col-md-6 col-md-offset-3">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Presupuesto
          </h3>
        </div>
        <!-- /.box-header -->
        
          <div class="box-body">
            <div class="form-group">
              <label for="title">Sucursal más cercana: </label>
              {{ $data->office() != null ? $data->office()->name : '' }}
            </div>
            <div class="form-group">
              <label for="title">Nombre: </label>
              {{ $data->name }}
            </div>
            <div class="form-group">
              <label for="title">Producto de interés: </label>
              {{ $data->product_of_interest }}
            </div>
            <div class="form-group">
              <label for="title">Contacto ({{ $data->displayContactMethod() }}): </label>
              {{ $data->contact_value }}
            </div>
            <div class="form-group">
              <label for="content">Mensaje</label>
              {{ $data->message }}
            </div>
            <div class="form-group">
              <label for="content">Estado</label>
              {!! $data->displayStatusLabel() !!}
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-success">Cambiar estado</button>
              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <?php foreach ($status as $key=>$value): if ($key == $data->status) continue; ?>
                <li><a href="javascript:;" data-value="{{ $key }}" class="change-status">{{ $value }}</a></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <a class="btn btn-warning" href="/cms/budgets">Cancelar</a>
          </div>
      </div>
      <!-- /.box -->
    </div>
  </form>
@stop