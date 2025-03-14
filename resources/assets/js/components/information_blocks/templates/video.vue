<template>
  <section class="information-block">
    <div class="information-block-video-background" v-if="is_home"></div>
    <div class="information-block-video">
      <iframe
        :src="`${url}?rel=0&amp;controls=0&amp;showinfo=0`"
        frameborder="0"
        allow=" encrypted-media"
        :style="style"
      ></iframe>
    </div>
  </section>
</template>

<script>
export default {
  props: ['data', 'is_home'],
  computed: {
    style() {
      return {
        width: window.innerWidth <= 600 ? '100%' : '90%',
      };
    },
    url() {  return (this.$props.data.video || '').replace('/watch?v=', '/embed/'); },
  }
}
</script>

<style scoped>
.information-block {
  position: relative;
}

.information-block-video {
  min-width: 100%;
}

.information-block-video iframe {
  display: block;
  margin: 0 auto;
  height: 100vh;
}

.information-block-video-background {
  height: 80%;
  left: 0;
  right: 0;
  top: 10%;
  bottom: 10%;
  background: #C52F33;
  position: absolute;
  z-index: -1;
}
</style>