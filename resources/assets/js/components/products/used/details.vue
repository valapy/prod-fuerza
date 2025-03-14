<template>
  <v-page>
    <div class="product-page">
      <div class="page-header products-header">
      </div>

      <div class="product-details" v-if="product">
        <div class="smooth-scroll">
          <div class="intro" id="price">
            <div class="container">
              <div class="col">
                <img :src="`/${product.image}`" class="product_image" v-if="product.image" />
              </div>
              <div class="col">
                <p class="spot-price">{{ product.model }}</p>
                <p class="financing-price">Contacto: {{ product.contact }}</p>

                <hr v-if="product.financing" />
                <div class="financing" v-if="product.financing">
                  <p class="financing-price">Cuotas desde <span>Gs.</span> {{ product.financing }}</p>
                </div>

                <div v-html="product.description"></div>
              </div>
            </div>
          </div>

        </div> 
      </div>
    </div>
  </v-page>
</template>

<script>
export default {
  computed: {
    product() {
      var result = this.$parent.used_products.filter(
        item => item.id == this.$route.params.id
      );
      if (result.length > 0) return result[0];
      this.$router.replace(404);
      return null;
    },
  },
  components: {
    "v-page": require("../../partials/page"),
  }
};
</script>
