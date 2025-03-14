<template>
  <v-page>
    <div class="content-page">
      <div class="page-header news-header">
        <h1>Noticias</h1>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12" v-for="row in news">
            <router-link :to="{ name: 'news-details', params: { id: row.id } }" class="news-item opacity">
              <div class="thumbnail" :style="{'background-image': `url(/${row.image})`}"></div>
              <div class="text">
                {{ row.title }}
                <hr />
                <div class="date">{{ row.date }}</div>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </v-page>
</template>

<script>
export default {
  computed: {
    news() {
      return this.$parent.news;
    },
  },
  components: {
    'v-page': require('../partials/page')
  }
}
</script>
