<template>
  <section class="information-block">
    <div class="information-block-image" v-bind:style="style">
      <div class="information-block-button" v-bind:class="{ [`button-align-${text_align}`]: true }">
        <a class="btn-red" :href="button.url">{{button.label}}</a>
      </div>
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
    button() {  return this.$props.data.button; },
    text_align() { return this.$props.data.text_align; },
  }
}
</script>

<style scoped>
.information-block-button {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 40px;
  padding: 0 20px;
  display: flex;
}

.information-block-button .btn-red {
  height: 30px;
  padding-left: 15px;
  padding-right: 15px;
  min-width: 150px;
  line-height: 35px;
  text-align: center;
  display: inline-block;
}

.button-align-center {
  justify-content: center;
}

.button-align-left {
  justify-content: flex-start;
}

.button-align-right {
  justify-content: flex-end;
}

@media (max-width: 600px) {
  .button-align-left {
    justify-content: center;
  }

  .button-align-right {
    justify-content: center;
  }
}
</style>