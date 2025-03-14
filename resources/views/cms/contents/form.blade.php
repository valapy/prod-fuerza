<!-- TODO: Implement the form -->
@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Contenido</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/cms.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('js')
    <script type="text/javascript" src="/js/cms.js"></script>
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
  <form role="form" method="POST" action="{{ action('CMS\ContentsController@update', $data->id) }}" enctype="multipart/form-data">

    @csrf
    <input name="_method" type="hidden" value="PUT">

    <div class="col-md-6 col-md-offset-3">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            <?=(isset($data) ? "Editar caso" : "Nuevo caso")?>
          </h3>
        </div>
        <!-- /.box-header -->
        
          <div class="box-body">
            <div class="form-group">
              <label for="title">Título</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="Título" value="<?=isset($data)? $data->title : ""?>">
            </div>
            <div class="form-group">
              <label for="content">Contenido</label>
              <textarea class="form-control editor" name="content" id="content" placeholder="Contenido"><?=isset($data)? $data->content : ""?></textarea>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-warning" href="javascript:window.history.back();">Cancelar</a>
          </div>
      </div>
      <!-- /.box -->
    </div>
  </form>
@stop