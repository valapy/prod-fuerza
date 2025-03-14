<div class="row">
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">
          Logo del producto
        </h3>
      </div>
      
      <div class="box-body">
        @if (isset($data) && file_exists($data->product_logo))
          <img src="/{{$data->product_logo}}" style="max-width: 100%" />
          <div class="form-check">
            <input type="hidden" name="_destroy_product_logo" value="false" />
            <input type="checkbox" name="_destroy_product_logo" value="true" />
            <label class="form-check-label">Borrar imagen</label>
          </div>
        @endif

        <div class="form-group">
          <p><i>Tamaño de la imágen 280x78 pixeles</i></p>
          <label for="images">Subir</label>
          <input type="file" class="form-control" name="product_logo" id="images" accept="image/*">
        </div>
      </div>
    </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">
          Imagen principal
        </h3>
      </div>
      
      <div class="box-body">
        @if (isset($data) && isset($data->header_image))
          <img src="/{{$data->header_image}}" style="max-width: 100%" />
          <div class="form-check">
            <input type="hidden" name="_destroy_header_image" value="false" />
            <input type="checkbox" name="_destroy_header_image" value="true" />
            <label class="form-check-label">Borrar imagen</label>
          </div>
        @endif

        <div class="form-group">
          <p><i>Tamaño recomendado de la imágen 1920x1080 pixeles</i></p>
          <label for="images">Subir</label>
          <input type="file" class="form-control" name="header_image" id="images" accept="image/*">
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">
          Imagen principal mobile
        </h3>
      </div>
      
      <div class="box-body">
        @if (isset($data) && isset($data->header_image_mobile))
          <img src="/{{$data->header_image_mobile}}" style="max-width: 100%" />
          <div class="form-check">
            <input type="hidden" name="_destroy_header_image_mobile" value="false" />
            <input type="checkbox" name="_destroy_header_image_mobile" value="true" />
            <label class="form-check-label">Borrar imagen</label>
          </div>
        @endif

        <div class="form-group">
          <p><i>Tamaño recomendado de la imágen 720x720 pixeles</i></p>
          <label for="images">Subir</label>
          <input type="file" class="form-control" name="header_image_mobile" id="images" accept="image/*">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">
      Galeria
    </h3>
  </div>
  
  <div class="box-body">
    @if (isset($data))
      <div class="form-group gallery" data-ref="{{ action('CMS\ProductImagesController@show', $data->id) }}" delete-ref="{{ action('CMS\ProductImagesController@destroy', '__ID__') }}">
        @foreach ($data->images as $row)
          <div class="deletable">
            <img src="/{{$row->image}}" style="max-width: 100%" />
            <a href="javascript:;" class="btn btn-danger" data-ref="{{ action('CMS\ProductImagesController@destroy', $row->id) }}">
              <span class="fa fa-trash"></span>
            </a>
          </div>
        @endforeach
      </div>
    @endif

    <div class="form-group">
      <p><i>Tamaño recomendado de la imágen 1920x1080 pixeles</i></p>
      <label for="images">Subir</label>
      <input type="file" class="form-control" name="images[]" id="images" multiple="" accept="image/*">
    </div>
  </div>
</div>
