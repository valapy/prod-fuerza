<template>
  <v-page :classes="['home-page']">
    <!-- ##### HEADER -->
    <header>
      <div
        id="gallery-home"
        class="gallery carousel slide"
        data-ride="carousel"
        data-interval="10000"
      >
        <div class="slide carousel-inner">
          <div
            class="cell carousel-item"
            :class="{ active: index === 0, 'is-video': row.type == 'video', 'is-image': row.type == 'image' }"
            v-for="(row, index) in home.carousel"
            :key="index"
          >
            <div class="image-container" v-if="isMobile" :style="carousel_media(row.media_mobile ? row.media_mobile : row.media)">
              <a :href="row.url" v-if="row.url && row.url.length > 0">&nbsp;</a>
            </div>
            <div class="image-container" v-else :style="carousel_media(row.media)">
              <a :href="row.url" v-if="row.url && row.url.length > 0">&nbsp;</a>
            </div>
          </div>
        </div>

        <div class="arrow arrow-left" v-if="!isMobile">
          <a href="#gallery-home" class="carousel-control-prev" role="button" data-slide="prev">
            <img src="/img/arrow-gray.png" alt="Anterior" />
          </a>
        </div>

        <div class="arrow arrow-right" v-if="!isMobile">
          <a href="#gallery-home" class="carousel-control-next" role="button" data-slide="next">
            <img src="/img/arrow-gray.png" alt="Siguiente" />
          </a>
        </div>

        <a href="http://www.diesa.com.py" class="btn-diesa opacity" target="_blank">
          <img src="/img/logo-diesa.svg" alt="Diesa S.A." />
        </a>
      </div>
    </header>

    <v-information-blocks :data="home.content" :is_home="true" />

    <!-- ##### INFO -->
    <section class="fixed info v-align-center text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="d-flex flex-xl-row flex-column">
              <div class="img-container align-self-center">
                <img src="/img/branch-offices.svg" alt="Concesionarias" />
              </div>
              <div class="d-flex flex-column align-items-center justify-content-center">
                <h1>CONCESIONARIA</h1>
                <p>Contactá con tu asesor de venta más cercano.</p>
                <div>
                  <router-link to="/branch_offices">Más información &gt;</router-link>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="d-flex flex-xl-row flex-column">
              <div class="img-container align-self-center">
                <img src="/img/products.svg" alt="Catálogo" />
              </div>
              <div class="d-flex flex-column align-items-center justify-content-center">
                <h1>CATÁLOGO</h1>
                <p class="text-center">Solicita un catálogo y descubrí todo lo que ofrecemos.</p>
                <div>
                  <router-link to="/products">Más información &gt;</router-link>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="d-flex flex-xl-row flex-column">
              <div class="img-container align-self-center">
                <img src="/img/contact.svg" alt="Contactános" />
              </div>
              <div class="d-flex flex-column align-items-center justify-content-center">
                <h1>CONTACTANOS</h1>
                <p class="text-center">Contactate con nosotros.</p>
                <div>
                  <router-link to="/contact_us">Más información &gt;</router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </v-page>
</template>

<script>
export default {
  data() {
    return {
      isMobile: false,
    }
  },
  computed: {
    home() {
      return this.$parent.home || { carousel: [], content: [] };
    },
    products() {
      return this.$parent.products || [];
    },
    news() {
      return this.$parent.news || [];
    }
  },
  methods: {
    carousel_media(media) {
      return {
        'background-image': `url(/${media})` 
      }
    },
    embed_url_for(url) {
      let id = this.get_id(url);

      if (id) {
        return `//www.youtube.com/embed/${id}?version=3&enablejsapi=1&modestbranding=1&autohide=1&controls=0`;
      } else {
        return null;
      }
    },
    get_id(url) {
      let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
      let match = url.match(regExp);

      if (match && match[2].length == 11) {
        return match[2];
      } else {
        return null;
      }
    },
    step(arr, step, continuousIndices) {
      return this.$parent.step(arr, step, continuousIndices);
    },
    update() {
      if(/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent)) {
        this.isMobile = true
      } else {
        this.isMobile = false
      }
    }
  },
  mounted() {
    this.update();
    var tag = document.createElement("script");
    var firstScriptTag = document.getElementsByTagName("script")[0];

    tag.src = "https://www.youtube.com/iframe_api";
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var videos = new Array();

    window.onYouTubeIframeAPIReady = function() {
      // Collect all elements from page that have [data-video] attribute
      const players = document.querySelectorAll(`[data-video]`);

      // Loop trough elements
      Array.from(players).forEach(video => {
        // Construct new YT player
        const player = new YT.Player(video.id, {
          // Targeting video by his random id attribute
          height: "100%",
          width: "100%",
          videoId: video.dataset.video // Loads videoId from data-video attribute
        });

        // Save our video id in custom property so we can easily find him later
        player.divid = video.id;

        // Push YT video object to array for future use
        videos.push(player);
      });
    };

    $("#gallery-home").on("slid.bs.carousel", function(e) {
      const slide = $(this).find(".active");
      const isVideo = slide.hasClass("is-video");

      videos.forEach(video => {
        video.pauseVideo();
      });

      if (isVideo) {
        const iframe = $(slide).find("iframe")[0];
        const videoId = $(iframe).attr("id");
        // Find index of current video by videoId
        const index = videos.map(e => e.divid).indexOf(videoId);

        // Save in video var, just to make it look nice
        const video = videos[index];

        // Do your thing here
        // video.setVolume(0);
        video.playVideo();
        $(this).carousel("pause");

        const wait = () => {
          if (video.getPlayerState() == 0) {
            video.stopVideo();
            $(this).carousel("next");
            $(this).carousel("cycle");
          } else {
            setTimeout(wait, 500);
          }
        };

        setTimeout(wait, 500);
      }
    });
  },
  created() {
    window.addEventListener('resize', this.update);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.update);
  },
  components: {
    "v-information-blocks": require("./information_blocks"),
    "v-page": require("./partials/page")
  }
};
</script>
