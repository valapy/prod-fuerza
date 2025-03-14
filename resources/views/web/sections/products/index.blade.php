@include('web/sections/products/header')

<div class="products-list">
  <transition-group name="fade" tag="div" class="row">
      <div class="col-md-4" v-for="(row, index) in filteredProducts()" :key="'product' + index">
      <a href="javascript:;" class="opacity">
        <img :src="'/' + row.product_image" :alt="row.model" />
        <p>@{{ row.model }}</p>
      </a>
    </div>
  </transition-group>
</div>