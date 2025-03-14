<template>
  <div>
    <div class="gallery-grid" v-if="product.images.length > 0">
      <a
        href="javascript:;"
        @click="image = row.image"
        :style="{ 'background-image': `url(/${row.image})` }"
        class="gallery-item opacity"
        v-for="row in product.images"
        :key="row.image"
      ></a>
    </div>

    <div class="overlay" v-if="image" @click="clear">
      <div
        id="gallery-product-images-overlay"
        class="gallery carousel slide carousel-fade"
        data-ride="carousel"
        data-interval="false"
      >
        <div class="slide carousel-inner">
          <div
            class="cell carousel-item"
            v-for="(row, index) in product.images"
            :class="{ active: image === row.image }"
            :key="index"
          >
            <div class="carousel-item-container">
              <img :src="`/${row.image}`" :alt="product.model" />
            </div>
          </div>
        </div>

        <div class="arrow arrow-left">
          <a
            href="#gallery-product-images-overlay"
            class="carousel-control-prev"
            role="button"
            data-slide="prev"
          >
            <img src="/img/arrow-gray.png" alt="Anterior" />
          </a>
        </div>

        <div class="arrow arrow-right">
          <a
            href="#gallery-product-images-overlay"
            class="carousel-control-next"
            role="button"
            data-slide="next"
          >
            <img src="/img/arrow-gray.png" alt="Siguiente" />
          </a>
        </div>
      </div>

      <a class="btn-close" href="javascript:;" @click="image=null">
        <img src="/img/btn-close.svg" align="Cerrar" />
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["product", "step"],
  data() {
    return {
      image: null
    };
  },
  methods: {
    clear() {
      if (!this.isMobile()) return
      this.image = null
    },
    isMobile() {
      if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true
      } else {
        return false
      }
    },
    keybind(e) {
      if (e.keyCode === 27) this.image = null;
    }
  }
};
</script>