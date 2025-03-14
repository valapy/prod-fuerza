<div class="form-group">
  <label for="intro">Código del producto</label>
  <input type="text" class="form-control" name="code" id="code" placeholder="Código del producto" value="<?=isset($data)? $data->code : ""?>" />
</div>
<div class="form-group">
  <label for="category">Categoría</label>
  <select class="form-control" name="category" id="category">
    @foreach ($categories as $value)
      <option value="{{$value}}"{{isset($data) && $data->category == $value ? " selected='selected'" : ""}}>{{$value}}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="model">Modelo</label>
  <input type="text" class="form-control" name="model" id="model" placeholder="Modelo" value="<?=isset($data)? $data->model : ""?>" />
</div>
<div class="form-group">
  <label for="intro">Introducción</label>
  <input type="text" class="form-control" name="intro" id="intro" placeholder="Introducción" value="<?=isset($data)? $data->intro : ""?>" />
</div>
<div class="form-group">
  <label for="pdf">En stock?</label>
  <input type="hidden" name="active" value="false" />
  <input type="checkbox" name="active" id="active" value="true" <?=isset($data) && $data->active ? 'checked="checked"' : ""?> />
</div>
<div class="form-group">
  <label for="pdf">PDF</label>
  <input type="file" class="form-control" name="pdf" id="pdf" accept=".pdf">
  @if (isset($data) && $data->pdf != NULL && file_exists($data->pdf))
    <a href="/{{$data->pdf}}" target="_blank">Previsualizar PDF</a>
    <div class="form-check">
      <input type="hidden" name="_destroy_pdf" value="false" />
      <input type="checkbox" name="_destroy_pdf" value="true" />
      <label class="form-check-label">Borrar PDF</label>
    </div>
  @endif
</div>

@push('js')
    <script>
        $(function(){
            $("#category").select2({
                tags: true
            });
        });
    </script>
@endpush
