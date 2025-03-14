<template>
  <!-- ##### PRODUCTS -->
  <section class="container">
    <div
      id="home-products"
      class="gallery carousel slide d-none d-md-block d-lg-block d-xl-block"
      data-ride="carousel"
      data-interval="5000"
    >
      <ol class="carousel-indicators">
        <li
          data-target="#home-products"
          :data-slide-to="i"
          :class="{ active: i == 0 }"
          v-for="i in step(filtered_products, 3, true)"
          :key="`a-${i}`"
        ></li>
      </ol>

      <div class="slide carousel-inner">
        <div
          class="carousel-item"
          v-for="i in step(filtered_products, 3)"
          :class="{ active: i === 0 }"
          :key="`b-${i}`"
        >
          <div class="row">
            <div class="col-md-4" v-for="row in filtered_products.slice(i, i+3)" :key="row.id">
              <router-link
                :to="{ name: 'product-details', params: { id: row.id } }"
                class="opacity"
              >
                <img :src="'/' + row.product_image" :alt="row.model" />
                <p>{{ row.model }}</p>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      id="home-products-mobile"
      class="gallery carousel slide d-block d-md-none d-lg-none d-xl-none"
      data-ride="carousel"
      data-interval="5000"
    >
      <ol class="carousel-indicators">
        <li
          data-target="#home-products"
          :data-slide-to="i"
          :class="{ active: i == 0 }"
          v-for="i in filtered_products"
          :key="`c-${i.id}`"
        ></li>
      </ol>

      <div class="slide carousel-inner">
        <div
          class="carousel-item"
          v-for="(row, i) in filtered_products"
          :class="{ active: i === 0 }"
          :key="`d-${row.id}`"
        >
          <div class="row">
            <div class="col-12">
              <router-link
                :to="{ name: 'product-details', params: { id: row.id } }"
                class="opacity"
              >
                <img :src="'/' + row.product_image" :alt="row.model" />
                <p>{{ row.model }}</p>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: ["current_product", "products", "step"],
  computed: {
    filtered_products() {
      let list = this.$props.products || [];

      if (this.$props.current_product) {
        list = list.filter(row => row.id !== this.$props.current_product.id);
      }

      return list;
    }
  }
};
</script>
