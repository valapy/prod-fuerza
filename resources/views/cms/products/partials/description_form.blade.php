<div class="description-app uninitialized">
  <div class="row">
    <input type="hidden" ref="data" name="{{ $table }}_attributes[{{ $i }}][data]" value="{{ isset($data) ? $data->data : "{}" }}" />
    <input type="hidden" ref="template" name="{{ $table }}_attributes[{{ $i }}][template]" value="{{ isset($data) ? $data->template : "" }}" />
    <div class="col-md-6">
      <div class="form-group">
        <label>Template</label>
        <select class="form-control" v-model="template">
          <option v-for="({label, value}) in templates" :value="value">@{{ label }}</option>
        </select>
      </div>
    </div>

    <div class="col-md-6" v-if="showColors()">
      <div class="form-group">
        <label>Color</label>
        <select class="form-control" v-model="color">
          <option v-for="({label, value}) in colors" :value="value">@{{ label }}</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <textarea ref="editor" v-if="showTextEditor()" class="form-control" placeholder="Descripción" v-model="text" ></textarea>
      <div v-if="showButton()">
        <div class="form-group">
          <label>Texto del boton</label>
          <input type="text" class="form-control" v-model="button.label" />
        </div>
        <div class="form-group">
          <label>Url del boton</label>
          <input type="text" class="form-control" v-model="button.url" />
        </div>
      </div>
      <div class="form-group" v-if="showVideo()">
        <label>Video</label>
        <input type="text" class="form-control" v-model="video" />
      </div>
      <div class="form-group" v-if="showAlign()">
        <label v-if="template === 'image+button'">Alineación del botón</label>
        <label v-else>Alineación del texto</label>
        <select class="form-control" v-model="text_align">
          <option value="center" v-if="showAlignCenter()">Centrado</option>
          <option value="left">Izquierda</option>
          <option value="right">Derecha</option>
        </select>
      </div>
      <div class="form-group" v-if="showTopLineAlignment()">
        <label>Alineación de la linea superior</label>
        <select class="form-control" v-model="top_line_alignment">
          <option value="center">Centrado</option>
          <option value="left">Izquierda</option>
          <option value="right">Derecha</option>
        </select>
      </div>
    </div>
    <div class="col-md-6" v-if="showImage()">
      @if (isset($data) && isset($data->image))
        <img src="/{{$data->image}}" style="max-width: 100%" />
        <div class="form-check">
        <input type="hidden" name="{{ $table }}_attributes[{{ $i }}][_destroy_image]" value="false" />
          <input type="checkbox" name="{{ $table }}_attributes[{{ $i }}][_destroy_image]" value="true" />
          <label class="form-check-label">Borrar imagen</label>
        </div>
      @endif    
      <div class="form-group">
        <p><i>Tamaño recomendado de la imágen 1920x1080 pixeles</i></p>
        <label>Subir</label>
        <input type="file" class="form-control" name="{{ $table }}_attributes[{{ $i }}][image]" multiple="" accept="image/*">
      </div>
    </div>
  </div>
</div>

<p>&nbsp;</p>

<button class="btn btn-danger btn-delete" type="button">Eliminar</button>

<input type="hidden" name="{{ $table }}_attributes[{{ $i }}][id]" value="<?= isset($data) ? $data->id : 0 ?>">
<input type="hidden" class="_destroy" name="{{ $table }}_attributes[{{ $i }}][_destroy]" value="false">
