<template>
  <button class="back-to-top" @click="goTop()">
    VOLVER ARRIBA
    <img src="/img/arrow-up-red.png" alt="Volver Arriba" />
  </button>
</template>

<script>
export default {
  methods: {
    isMobile() {
      if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true
      } else {
        return false
      }
    },
    goTop() {
      $('html, body').animate({scrollTop: '0px'}, 200);
    },
    toggle() {
      if (
        !this.isMobile() &&
        (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) && 
        (window.innerHeight + window.scrollY) >= ($('.page').height() - 30)
      ) {
        $(this.$el).show()
      } else {
        $(this.$el).hide()
      }
    }
  },
  mounted() {
    $(this.$el).hide()
    window.addEventListener('scroll', this.toggle)
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.toggle)
  }
}
</script>