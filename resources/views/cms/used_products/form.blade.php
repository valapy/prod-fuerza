@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Usados</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/cms.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@push('js')
    <script type="text/javascript" src="/js/cms.js"></script>
@endpush

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
  <form role="form" method="POST" action="{{ action('CMS\UsedProductsController@update', $data->id) }}" enctype="multipart/form-data">
  <?php else: ?>
  <form role="form" method="POST" action="{{ action('CMS\UsedProductsController@store') }}" enctype="multipart/form-data">
  <?php endif; ?>

    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            <?=(isset($data) ? "Editar usado" : "Nuevo usado")?>
          </h3>
        </div>
        <!-- /.box-header -->

          @csrf
          @if (isset($data))
            <input name="_method" type="hidden" value="PUT">
          @endif

          <div class="box-body">
            <div class="form-group">
              <label for="name">Modelo</label>
              <input type="text" class="form-control" name="model" id="model" placeholder="Modelo" value="<?=isset($data)? $data->model : ""?>">
            </div>
            <div class="form-group">
              <label for="contact">Contacto</label>
              <input type="text" class="form-control" name="contact" id="contact" placeholder="Contacto" value="<?=isset($data)? $data->contact : ""?>">
            </div>
            <div class="form-group">
              <label for="financing">Cuotas desde</label>
              <input type="text" class="form-control" name="financing" id="financing" placeholder="Cuotas desde" value="<?=isset($data)? $data->financing : ""?>">
            </div>
            <div class="form-group">
              <label>Descripción</label>
              <textarea class="form-control editor" name="description"><?=isset($data)? $data->description : ""?></textarea>
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

    <div class="col-md-6" v-if="showImage()">
      @if (isset($data) && isset($data->image))
        <img src="/{{$data->image}}" style="max-width: 100%" />
        <div class="form-check">
        <input type="hidden" name="_destroy_image" value="false" />
          <input type="checkbox" name="_destroy_image" value="true" />
          <label class="form-check-label">Borrar imagen</label>
        </div>
      @endif    
      <div class="form-group">
        <p><i>Tamaño recomendado de la imágen 1920x1080 pixeles</i></p>
        <label>Subir</label>
        <input type="file" class="form-control" name="image" accept="image/*">
      </div>
    </div>
  </form>
@stop