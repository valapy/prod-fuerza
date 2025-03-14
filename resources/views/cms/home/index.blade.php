@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Contenido de la portada</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/cms.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@push('js')
    <script type="text/javascript" src="/js/cms.js"></script>
@endpush

@section('content')
  <!-- form start -->
  <form role="form" method="POST" action="{{ action('CMS\HomeController@index') }}" enctype="multipart/form-data">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Contenido de la portada</h3>
        <div class="pull-right">
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </div>
      <!-- /.box-header -->

      <div class="box-body">
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

        @csrf

        <div id="description-root">
          @component('components.nested_form', [ 'data' => isset($data) ? $data : [], 'table' => 'product_descriptions', 'partial' => 'cms.products.partials.description_form' ])
          @endcomponent
        </div>
      </div>
      <!-- /.box-body -->
    </div>
  </form>
@stop
