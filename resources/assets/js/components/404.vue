<template>
  <v-page height="100%">
    <div class="page-not-found">
      <div 
        class="background-image"
        v-if="image"
        :style="{ 'background-image': `url(/${image})` }"
      ></div>
      <h1>Página no encontrada</h1>
      <router-link to="/home" class="btn btn-red">Ir a la página principal</router-link>
    </div>
  </v-page>
</template>

<script>
export default {
  computed: {
    image: function() {
      return this.$parent.home.carousel && this.$parent.home.carousel.length > 0 ? this.$parent.home.carousel[0].image : null
    }
  },
  components: {
    'v-page': require('./partials/page')
  }
}
</script>