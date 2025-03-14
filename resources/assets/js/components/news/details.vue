<template>
  <v-page>
    <div class="news-page">
      <div class="page-header news-header">
        <h1>Noticias</h1>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-10 offset-md-1" v-if="news">
            <div class="thumbnail" v-bind:style="{ 'background-image': 'url(/' + news.image + ')' }"></div>

            <h1 class="text-center">{{ news.title }}</h1>
            <hr>
            <span class="date">{{ news.date }}</span>
            <div class="clear"></div>
            <div v-html="news.content"></div>
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
      if (this.$parent.news.length > 0) {
        for (var i in this.$parent.news) {
          if (this.$parent.news[i].id == this.$route.params.id) return this.$parent.news[i]
        }

        this.$router.replace('/404');
        return null;
      }

      return null;
    },
  },
  components: {
    'v-page': require('../partials/page')
  }
}
</script>