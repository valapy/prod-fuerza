@extends('adminlte::page')

@section('title', 'Honda')

@section('content_header')
    <h1>Usuarios</h1>
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

  <div class="col-md-6 col-md-offset-3">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          <?=(isset($data) ? "Editar usuario" : "Nuevo usuario")?>
        </h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <?php if (isset($data)): ?>
      <form role="form" method="POST" action="{{ action('CMS\UsersController@update', $data->id) }}">
      <?php else: ?>
      <form role="form" method="POST" action="{{ action('CMS\UsersController@store') }}">
      <?php endif; ?>

        @csrf
        @if (isset($data))
          <input name="_method" type="hidden" value="PUT">
        @endif

        <div class="box-body">
          <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Nombre del usuario" value="<?=isset($data)? $data->name : ""?>">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email del usuario" value="<?=isset($data)? $data->email : ""?>">
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña">
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirmar constraseña</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirmar contraseña">
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <a class="btn btn-warning" href="javascript:window.history.back();">Cancelar</a>
        </div>
      </form>
    </div>
    <!-- /.box -->

  </div>
@stop