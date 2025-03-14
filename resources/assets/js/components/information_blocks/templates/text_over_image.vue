<template>
  <section class="information-block" v-bind:class="{ [`text-align-${text_align}`]: true }">
    <div class="information-block-image" v-bind:style="style">
      <div class="information-block-text" v-html="text"></div>
    </div>
  </section>
</template>

<script>
export default {
  props: ['data', 'image'],
  computed: {
    style() {
      return {
        backgroundImage: `url(/${this.$props.image})`,
      }
    },
    text() {  return this.$props.data.text; },
    text_align() {  return this.$props.data.text_align; },
  }
}
</script>

<style scoped>
.information-block-image {
  display: flex;
  align-items: center;
}

.information-block-text {
  padding: 20px;
  display: flex;
  width: 50%;
  flex-direction: column;
}

.text-align-center .information-block-image {
  justify-content: center;
}

.text-align-left .information-block-image {
  justify-content: flex-start;
}

.text-align-right .information-block-image {
  justify-content: flex-end;
}

@media (max-width: 600px) {
  .text-align-left .information-block-image, 
  .text-align-right .information-block-image,
  .text-align-center .information-block-image {
    justify-content: flex-start;
  }

  .information-block-text {
    width: 100%;
  }
}
</style>