<template>
  <div class="information-block-container">
    <div v-for="(row, index) in data" :key="index">
      <v-text-image :data="row.data" :image="row.image" :is_home="is_home" v-if="row.template === 'text+image'" />
      <v-text-over-image :data="row.data" :image="row.image" :is_home="is_home" v-if="row.template === 'text-over-image'" />
      <v-image-button :data="row.data" :image="row.image" :is_home="is_home" v-if="row.template === 'image+button'" />
      <v-video :data="row.data" :is_home="is_home" v-if="row.template === 'video'" />
    </div>
  </div>
</template>

<script>
export default {
  props: ['data', 'is_home'],
  components: {
    'v-text-image': require('./templates/text_image'),
    'v-text-over-image': require('./templates/text_over_image'),
    'v-image-button': require('./templates/image_button'),
    'v-video': require('./templates/video'),
  }
}
</script>