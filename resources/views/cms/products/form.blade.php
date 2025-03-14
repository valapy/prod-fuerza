@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Productos</h1>
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
  <form role="form" method="POST" action="{{ action('CMS\ProductsController@update', $data->id) }}" enctype="multipart/form-data">
  <?php else: ?>
  <form role="form" method="POST" action="{{ action('CMS\ProductsController@store') }}" enctype="multipart/form-data">
  <?php endif; ?>

    @csrf
    @if (isset($data))
      <input name="_method" type="hidden" value="PUT">
    @endif

    <div class="pull-right">
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a class="btn btn-warning" href="javascript:window.history.back();">Cancelar</a>
    </div>

    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#details" data-toggle="tab" aria-expanded="true">Detalles</a></li>
        <li><a href="#pricing" data-toggle="tab" aria-expanded="true">Precios</a></li>
        <li><a href="#colors" data-toggle="tab" aria-expanded="true">Colores</a></li>
        <li><a href="#description" data-toggle="tab" aria-expanded="true">Descripción</a></li>
        <li><a href="#specs" data-toggle="tab" aria-expanded="true">Ficha Técnica</a></li>
        <li><a href="#photos" data-toggle="tab" aria-expanded="true">Fotos</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="details"> @include('cms.products.partials.details', compact('data')) </div>
        <div class="tab-pane" id="pricing"> @include('cms.products.partials.pricing', compact('data')) </div>
        <div class="tab-pane" id="colors"> @include('cms.products.partials.colors', compact('data')) </div>
        <div class="tab-pane" id="description"> @include('cms.products.partials.description', compact('data')) </div>
        <div class="tab-pane" id="specs"> @include('cms.products.partials.specs', compact('data')) </div>
        <div class="tab-pane" id="photos"> @include('cms.products.partials.photos', compact('data')) </div>
      </div>
    </div>
  </form>
@stop
