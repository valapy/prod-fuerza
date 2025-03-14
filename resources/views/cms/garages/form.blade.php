@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Servicios &amp; Repuestos</h1>
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
  <form role="form" method="POST" action="{{ action('CMS\GaragesController@update', $data->id) }}" enctype="multipart/form-data">
  <?php else: ?>
  <form role="form" method="POST" action="{{ action('CMS\GaragesController@store') }}" enctype="multipart/form-data">
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
            <?=(isset($data) ? "Editar servicios &amp; repuestos" : "Nueva servicios &amp; repuestos")?>
          </h3>
        </div>
        <!-- /.box-header -->
          
          <input type="hidden" id="lat" name="lat" value="<?=isset($data)? $data->lat : ""?>">
          <input type="hidden" id="lng" name="lng" value="<?=isset($data)? $data->lng : ""?>">

          <div class="box-body">
            <div class="form-group">
              <label for="name">Nombre</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Nombre" value="<?=isset($data)? $data->name : ""?>">
            </div>
            <div class="form-group">
              <label for="phone">Teléfono</label>
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Teléfono" value="<?=isset($data)? $data->phone : ""?>">
            </div>
            <div class="form-group">
              <label for="email">E-mail</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="E-mail" value="<?=isset($data)? $data->email : ""?>">
            </div>
            <div class="form-group">
              <label for="address">Dirección</label>
              <input type="text" class="form-control" name="address" id="address" placeholder="Dirección" value="<?=isset($data)? $data->address : ""?>">
            </div>

            @if (isset($data) && isset($data->image) && $data->image != "")
              <div class="form-group">
                <img src="/{{$data->image}}" width="100%" />
              </div>
            @endif

            <div class="form-group">
              <label for="image">Imagen</label>
              <input type="file" class="form-control" name="image" id="image">
              <p><i>Tamaño recomendado 476x336 pixeles</i></p>          
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-warning" href="javascript:window.history.back();">Cancelar</a>
          </div>
      </div>
    </div>
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Ubicación
          </h3>
        </div>
        <!-- /.box-header -->
        
          <div class="box-body">
            <div class="input-group">
              <input type="text" class="form-control" id="search" name="search" id="search" placeholder="Buscar" aria-describedby="btn-search">
              <span class="input-group-btn">
                <button class="btn btn-primary btn-flat" type="button" id="btn-search">
                  <i class="fa fa-fw fa-search"></i>
                </button>
              </div>
            </div>
            <i>Escribir la dirección que desea buscar y luego hacer click en el mapa para marcar la ubicación actual de la misma, a modo de poder mostrar el marcador de la ubicación en el mapa.</i>
            <div id="map" style="width: 100%; height: 280px;"></div>
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </form>
@stop

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHK1kF4fVFPAhM_oc_Z4QroldC9hSk2Qs&libraries=places"></script>
    <script type="text/javascript">
      var map, geocoder, marker;

      $(function(){
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: <?=isset($data) && $data->lat ? $data->lat : '-25.3142998'?>, lng: <?=isset($data) && $data->lng ? $data->lng : '-57.5842887'?>},
          zoom: 15
        });

        geocoder = new google.maps.Geocoder();

        google.maps.event.addListener(map, 'click', function(event) {
         placeMarker(event.latLng.lat(), event.latLng.lng());
        });

        $('#btn-search').on('click', function() {
          searchAddress($('#search').val());
        });
      });

      @if (isset($data) && $data->lat && $data->lng)
        placeMarker(<?=$data->lat?>, <?=$data->lng?>);
      @endif

      function placeMarker(lat, lng) {
        if (marker) marker.setMap(null);
        $('#lat').val(lat);
        $('#lng').val(lng);
        marker = new google.maps.Marker({
          position: { lat: lat, lng: lng }, 
          map: map
        });
      }

      function searchAddress(address) {
        console.log(address);
        geocoder.geocode({
          'address': address
        }, function (result, status) {
          console.log(result, status);
          if (status == google.maps.GeocoderStatus.OK) {
            map.panTo(result[0].geometry.location)
          }
        });
      }
    </script>
@stop