<template>
  <section class="information-block" v-bind:class="{ [`text-align-${text_align}`]: true, [`information-block-${color}`]: true }">
    <div class="information-block-text">
      <div class="text-content">
        <hr :class="top_line_alignment" />
        <div v-html="text"></div>
      </div>
    </div>
    <div class="information-block-image" v-bind:style="style"></div>
  </section>
</template>

<script>
export default {
  props: ['data', 'image'],
  computed: {
    color() { return this.$props.data.color || 'white'; },
    style() {
      return {
        backgroundImage: `url(/${this.$props.image})`,
      }
    },
    text() { return this.$props.data.text; },
    text_align() { return this.$props.data.text_align; },
    top_line_alignment() { return { [this.$props.data.top_line_alignment || 'left'] : true}; },
  }
}
</script>

<style scoped>
.information-block-image {
  display: flex;
  align-items: center;
}

.information-block-text {
  display: flex;
  flex: 1;
  align-items: center;
  padding: 0;
}

.information-block-text .text-content {
  padding: 30px;
  width: 100%;
}

.information-block-image {
  flex: 1;
}

.text-align-left {
  flex-direction: row;
}

.text-align-right {
  flex-direction: row-reverse;
}

@media (max-width: 600px) {
  .information-block-image {
    min-height: 300px;
  }

  .text-align-left {
    flex-direction: column-reverse;
  }

  .text-align-right {
    flex-direction: column;
  }
}
</style>
