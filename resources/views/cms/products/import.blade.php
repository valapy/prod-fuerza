<!-- TODO: Implement pagination (check data table in adminlte site) -->
@extends('adminlte::page')

@section('title', 'Honda')

@push('js')
    <script type="text/javascript" src="/js/cms.js"></script>
@endpush

@section('content')
  @if (isset($error))
    <div class="callout callout-danger">{{ $error }}</div>
  @elseif (isset($success))
    <div class="callout callout-success">{{ $success }}</div>
  @endif
  <h3>Importar productos</h3>
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Seleccione el archivo de Excel (XLSX) que desea importar</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <form role="form" method="POST">
              @csrf
              <input type="hidden" id="type" name="type" value="product" />
              <input type="hidden" id="data" name="data" />
              <div class="form-group">
                  <label for="video">Archivo</label>
                  <input type="file" class="form-control" name="import_products_xlsx" id="import_products_xlsx" placeholder="XLSX">
                  <i>
                      El archivo XLSX tiene un formato especifico, puede descargar el siguiente archivo como referencia
                      haciendo click <a href="/examples/csv_products.xlsx" target="_blank">aqui</a>
                  </i>
              </div>
          </form>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>

  <h3>Importar precios</h3>
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Seleccione el archivo de Excel (XLSX) que desea importar</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <form role="form" method="POST">
              @csrf
              <input type="hidden" id="type" name="type" value="pricing" />
              <input type="hidden" id="data" name="data" />
              <div class="form-group">
                  <label for="video">Archivo</label>
                  <input type="file" class="form-control" name="import_pricing_xlsx" id="import_pricing_xlsx" placeholder="XLSX">
                  <i>
                      El archivo XLSX tiene un formato especifico, puede descargar el siguiente archivo como referencia
                      haciendo click <a href="/examples/csv_pricing.xlsx" target="_blank">aqui</a>
                  </i>
              </div>
          </form>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
@stop
