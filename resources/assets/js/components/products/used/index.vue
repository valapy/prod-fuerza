<template>
  <v-page>
    <div class="product-page">
      <div class="page-header products-header">
      </div>

      <div class="products-list container">
        <transition-group name="fade" tag="div" class="row">
          <div class="col-md-4" v-for="(row, index) in products" v-bind:key="'product' + index">
            <router-link :to="{name: 'used-product-details', params: params(row) }" class="opacity">
              <img :src="'/' + row.image" :alt="row.model" v-if="row.image && row.image.length > 0" />
              <img src="/img/motorbike_placeholder.svg" :alt="row.model" v-if="!row.image || row.image.length === 0">
              <p>{{ row.model }}</p>
            </router-link>
          </div>
        </transition-group>
      </div>
    </div>
  </v-page>
</template>

<script>
const slugify =require('slugify');

export default {
  computed: {
    products() {
      return this.$parent.used_products
    },
  },
  methods: {
    params(product) {
      return {
        slug: slugify(product.model),
        id: product.id,
      }
    }
  },
  components: {
    'v-page': require('../../partials/page')
  }
}
</script>
