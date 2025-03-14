<!-- TODO: Implement the form -->
@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Noticias</h1>
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
  <?php if (isset($data)): ?>
  <form role="form" method="POST" action="{{ action('CMS\NewsController@update', $data->id) }}" enctype="multipart/form-data">
  <?php else: ?>
  <form role="form" method="POST" action="{{ action('CMS\NewsController@store') }}" enctype="multipart/form-data">
  <?php endif; ?>

    @csrf
    @if (isset($data))
      <input name="_method" type="hidden" value="PUT">
    @endif

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
              <label for="date">Fecha</label>
              <input type="text" class="form-control" name="date" id="date" placeholder="Fecha" value="<?=isset($data)? $data->date : ""?>">
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
    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Fotos
          </h3>
        </div>
        
        <div class="box-body">
          <p><i>Tamaño recomendado 1920x1080 pixeles</i></p>          
          @if (isset($data) && isset($data->image) && $data->image != "")
            <div class="form-group">
              <img src="/{{$data->image}}" width="100%" />
            </div>
          @endif

          <div class="form-group">
            <label for="image">Subir</label>
            <input type="file" class="form-control" name="image" id="image">
          </div>
        </div>
      </div>
    </div>
  </form>
@stop