@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Imágenes de la Portada</h1>
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
  <form role="form" method="POST" action="{{ action('CMS\HomeCarouselController@update', $data->id) }}" enctype="multipart/form-data">
  <?php else: ?>
  <form role="form" method="POST" action="{{ action('CMS\HomeCarouselController@store') }}" enctype="multipart/form-data">
  <?php endif; ?>

    @csrf
    @if (isset($data))
      <input name="_method" type="hidden" value="PUT">
    @endif

    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            <?=(isset($data) ? "Editar cliente" : "Nuevo cliente")?>
          </h3>
        </div>
        <!-- /.box-header -->
        
          <div class="box-body">
            <div class="form-group">
              <label for="name">Descripción</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Descripción" value="<?=isset($data)? $data->name : ""?>">
            </div>

            <div class="form-group">
              <label for="url">Enlace de la imagen</label>
              <input type="text" class="form-control" name="url" id="url" placeholder="URL" value="<?=isset($data)? $data->url : ""?>">
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
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Imagen
          </h3>
        </div>
        
        <div class="box-body">
          <p><i>Tamaño recomendado 1920x1080 pixeles</i></p>          
          @if (isset($data) && isset($data->media) && $data->media != "")
            <div class="form-group">
              <img src="/{{$data->media}}" width="100%" />
            </div>
          @endif

          <div class="form-group">
            <label for="media">Media</label>
            <div id="media_holder">
              <input type="file" class="form-control" name="media" id="media" accept="image/x-png,image/jpeg">
            </div>
          </div>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Imagen para mobile
          </h3>
        </div>
        
        <div class="box-body">
          <p><i>Tamaño recomendado 480x640 pixeles</i></p>          
          @if (isset($data) && isset($data->media_mobile) && $data->media_mobile != "")
            <div class="form-group">
              <img src="/{{$data->media_mobile}}" width="100%" />
            </div>
          @endif

          <div class="form-group">
            <label for="media">Media</label>
            <div id="media_holder">
              <input type="file" class="form-control" name="media_mobile" id="media_mobile" accept="image/x-png,image/jpeg">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@stop

@section('js')
    <script>
      $(function(){
        $('#type').on('change', () => {
          let value = $('#type option:selected').val();
          let input = $('#media');
          input.attr('type', value == 'image' ? 'file' : 'text');
          input.attr('value', null);
        })
      });
    </script>
@stop
