<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="model">Color</label>
      <span class="input-group-addon" id="color-preview" style="background-color: <?=isset($data)? $data->color : ""?>">&nbsp;</span>
      <input type="text" class="form-control color-source" name="{{ $table }}_attributes[{{ $i }}][color]" id="{{ $table }}_attributes[{{ $i }}][color]" placeholder="Color" value="<?=isset($data)? $data->color : ""?>">
      <p><i>Color en hexadecimal. Ej: #ffffff</i></p>
    </div>
  </div>
  <div class="col-md-6">
    @if (isset($data) && isset($data->image))
      <img src="/{{$data->image}}" style="max-width: 100%" />
      <div class="form-check">
        <input type="hidden" name="{{ $table }}_attributes[{{ $i }}][_destroy_image]" value="false" />
        <input type="checkbox" name="{{ $table }}_attributes[{{ $i }}][_destroy_image]" value="true" />
        <label class="form-check-label">Borrar imagen</label>
      </div>
    @endif

    <div class="form-group">
      <p><i>Tamaño recomendado de la imágen 720x720 pixeles</i></p>
      <label>Subir</label>
      <input type="file" class="form-control" name="{{ $table }}_attributes[{{ $i }}][image]" multiple="" accept="image/*">
    </div>
  </div>
</div>

<button class="btn btn-danger btn-delete" type="button">Eliminar</button>

<input type="hidden" name="{{ $table }}_attributes[{{ $i }}][id]" value="<?= isset($data) ? $data->id : 0 ?>">
<input type="hidden" class="_destroy" name="{{ $table }}_attributes[{{ $i }}][_destroy]" value="false">

@push('js')
  <script>
    $(function(){
      $(document).on('keyup', '.color-source', function() {
        let color = $(this).val();
        console.log(color);
        $(this).parent().find('#color-preview').css({ backgroundColor: color });
      });
    });
  </script>
@endpush