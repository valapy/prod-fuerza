<template>
  <div class="page" :style="{ height : height }">
    <div :class="_classes">
      <slot></slot>
      <v-footer :sticky="sticky"></v-footer>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    classes: Array, 
    height: String, 
    sticky: {
      type: Boolean,
      default: false,
    }
  },
  computed: {
    _classes() {
      const clss = {};
      (this.$props.classes || []).forEach(cls => clss[cls] = true);
      return { ...(clss || {}), 'inner-page': true }
    },
  },
  components: {
    'v-footer': require('./footer')
  }
}
</script>
