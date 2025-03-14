<template>
  <v-page>
    <div class="product-page">
      <div class="page-header products-header">
        <div class="container">
          <ul class="filter-list no-list inline-list d-none d-lg-block d-xl-block">
            <li v-for="row in categories" :key="row">
              <router-link
                :to="{name: 'products', query: { category: row }}"
                :class="{ active: product && row == product.category }"
              >{{ row }}</router-link>
            </li>
          </ul>

          <div class="dropdown d-block d-lg-none d-xl-none">
            <button
              class="btn dropdown-toggle"
              type="button"
              id="dropdownMenuButton"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >Buscar</button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a
                href="javascript:;"
                @click="resetFilters()"
                class="dropdown-item router-link-active"
              >Todos</a>
              <router-link
                :to="{ name: 'products', query: { category: row } }"
                v-for="row in categories"
                class="dropdown-item"
                :key="row"
              >{{ row }}</router-link>
            </div>
          </div>
        </div>
      </div>

      <div class="product-details" v-if="product">
        <header
          class="background-image d-none d-sm-block d-xs-block"
          :style="{ 'background-image': `url(/${product.header_image})` }"
          v-if="product.header_image"
        ></header>
        <header
          class="background-image d-block d-sm-none d-xs-none"
          :style="{ 'background-image': `url(/${product.header_image_mobile || product.header_image})` }"
          v-if="product.header_image_mobile || product.header_image"
        ></header>
        <div class="scroll-menu inline-list">
          <ul class="no-list">
            <li class="active"><a href="#price">Precio</a></li>
            <li><a href="#details">Detalles</a></li>
            <li><a href="#specs">Ficha Técnica</a></li>
          </ul>
        </div>
        <div class="smooth-scroll">
          <div class="intro" id="price">
            <div class="container">
              <div class="col">
                <img :src="`/${current_product_image}`" class="product_image" v-if="current_product_image" />
              </div>
              <div class="col">
                <img :src="`/${product.product_logo}`" class="product_logo" />
                <div class="intro-text" v-html="product.intro"></div>

                <p class="spot-price" v-if="product.spot_price2 && product.spot_price2.length > 0"><span>{{ product.moneda }}</span> {{ product.spot_price2 }}</p>

                <!-- <p class="spot-price" ><span>Gs.</span> {{ product.spot_price2 }}</p> -->

                <hr v-if="colors && colors[current_color_index].color" />
                <div class="colors" v-if="colors && colors[current_color_index].color">
                  <p>
                    Colores disponibles:
                    <ul class="no-list inline-list">
                      <li :key="i" v-for="(row, i) in colors" :style="getStyleColor(row)" @click="current_color_index = i"></li>
                    </ul>
                  </p>
                </div>

                <hr v-if="current_pricing" />
                <div class="financing" v-if="current_pricing">
                  
                  <p>
                    Financiación en cuotas:
                    <select v-model="current_pricing">
                      <!-- <option :value="row.value" :key="i" v-for="(row, i) in product.pricing">{{ row.field }}</option> -->
                      <option :value="product.pricing[0].value">{{ product.pricing[0].field }}</option>
                      <option :value="product.pricing[1].value">{{ product.pricing[1].field }}</option>
                      <!-- <option :value="row.value" :key="i" v-for="(row, i) in product.pricing">{{ row.field }}</option> -->
                    </select>
                  </p>
                  <p class="financing-price" v-if="current_pricing"><span>{{ product.moneda }}</span> {{ current_pricing }}</p>
                  <div v-html="product.financing_requirements"></div>
                </div>
              </div>
            </div>
          </div>

          <div id="details">
            <v-information-block :data="product.descriptions" />
          </div>

          <div id="specs">
            <v-specs :product="product" />
          </div>

          <v-gallery :product="product" :step="step" />

          <v-products
            :products="related_products"
            :current_product="product"
            :step="step"
            class="other-products"
          />
        </div> 
      </div>
    </div>
  </v-page>
</template>

<script>
export default {
  data() {
    return {
      image: null,
      current_pricing: null,
      current_color_index: null,
    };
  },
  computed: {
    colors() {
      const colors = (this.product || {}).colors || [];
      if (colors.length === 0) return null;
      return colors;
    },
    current_color() {
      return this.colors ? this.colors[this.current_color_index] : null;
    },
    current_product_image() {
      return (this.current_color || {}).image || (this.colors || [{}]).image || null;
    },
    default_color() {
      return this.colors ? this.colors[0] : null;
    },
    default_pricing() {
      const pricing = (this.product || {}).pricing || []
      if (pricing.length === 0) return null;
      return this._current_pricing || this.product.pricing[0].value;
    },
    product() {
      var result = this.products.filter(
        item => item.id == this.$route.params.id
      );
      if (result.length > 0) return result[0];
      this.$router.replace(404);
      return null;
    },
    products() {
      return this.$parent.products;
    },
    related_products() {
      return this.$parent.products.filter(row => row.category === this.product.category);
    },
    categories() {
      return this.$parent.product_categories || [];
    }
  },
  methods: {
    getStyleColor(data) {
      return {
        backgroundColor: data ? data.color : '',
      }
    },
    step(arr, step, continuousIndices) {
      return this.$parent.step(arr, step, continuousIndices);
    },
    isEven(n) {
      return n % 2 == 0;
    },
    isOdd(n) {
      return Math.abs(n % 2) == 1;
    },
    init() {
      if (this.product) {
        this.$parent.current_product = this.product;

        if (!this.current_pricing) {
          this.current_pricing = this.default_pricing;
        }

        if (!this.current_color_index) {
          this.current_color_index = 0;
        }
      }
    },
  },
  watch: {
    product: {
      handler() {
        this.init();
      }
    }
  },
  mounted() {
    document.body.addEventListener("keyup", this.keybind);
    this.init();
  },
  beforeDestroy() {
    document.body.removeEventListener("keyup", this.keybind);
    this.$parent.current_product = null;
  },
  components: {
    'v-information-block': require('../../information_blocks'),
    "v-gallery": require("./gallery"),
    "v-page": require("../../partials/page"),
    "v-products": require("../../partials/products_carousel"),
    "v-specs": require("./specs")
  }
};
</script>
