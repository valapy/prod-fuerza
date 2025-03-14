<div class="page" v-if="isRouteActive('products', 'id', false)" key="product">
  <div class="container">
    @include('web/sections/products/index')
  </div>
  @include('web/partials/footer')
</div>

<div class="page" v-if="isRouteActive('products', 'id', true)" key="product-details">
  <div class="container">
    @include('web/sections/products/details')
  </div>
  @include('web/partials/footer')
</div>