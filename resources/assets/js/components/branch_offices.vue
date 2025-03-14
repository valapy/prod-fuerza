<template>
  <v-page>
    <div class="content-page">
      <div class="page-header">
        <h1>Concesionarias</h1>
      </div>

      <div class="container">
        <div class="row office-list">
          <div class="col-12" v-html="content"></div>
          <div class="col-12 d-none d-md-block d-lg-block d-xl-block">
            <div id="office-map" class="map" style="height: 700px;"></div>
          </div>
          <div class="col-xs-12 col-md-4 item" v-for="(row, index) in offices">
            <a :href="`https://www.google.com/maps/search/?api=1&query=${row.lat},${row.lng}&query_place_id=${row.id}`" target="_blank" @click="setActive(row, $event, markers[index])">
              <img :src="`/${row.image}`" v-if="row.image && row.image.length > 0" />
              <img src="/img/store-placeholder.png" v-if="!row.image || row.image.length === 0" />
              <h2>{{row.name}}</h2>
              <p>
                {{row.phone}}<br v-if="row.phone">
                {{row.email}}<br v-if="row.email">
                {{row.address}}
              </p>
              <p class="btn btn-danger d-block d-md-none d-lg-none d-xl-none">Como llegar</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </v-page>
</template>

<script>
export default {
  data() {
    return {
      service: null,
      map: null,
      markers: [],
      infowindow: null
    }
  },
  computed: {
    title() {
      return this.$parent.content['branch-offices'] ? this.$parent.content['branch-offices'].title : ''
    },
    content() {
      return this.$parent.content['branch-offices'] ? this.$parent.content['branch-offices'].content : ''
    },
    offices() {
      return this.$parent.branch_offices;
    },
  },
  methods: {
    setActive(place, event, marker) {
      if( navigator.userAgent.match(/Android/i)
         || navigator.userAgent.match(/webOS/i)
         || navigator.userAgent.match(/iPhone/i)
         || navigator.userAgent.match(/iPad/i)
         || navigator.userAgent.match(/iPod/i)
         || navigator.userAgent.match(/BlackBerry/i)
         || navigator.userAgent.match(/Windows Phone/i)
      ){
        return;
      }

      if (event) event.preventDefault()
      this.map.setCenter({ lat: parseFloat(place.lat), lng: parseFloat(place.lng) });
      this.map.setZoom(16);
      this.showTooltip(marker);

      $([document.documentElement, document.body]).animate({
        scrollTop: $("#office-map").offset().top
      }, 1000);
    },
    showTooltip(marker) {
      this.infowindow.setContent(marker.content);
      this.infowindow.open(this.map, marker);
    },
    setupMarkers() {
      for (var i in this.markers) {
        this.markers[i].setMap(null);
      }

      this.markers = [];

      var bounds = new google.maps.LatLngBounds();
      this.infowindow = new google.maps.InfoWindow({
        content: ''
      });

      for (var i in this.offices) {
        var place = this.offices[i];
        var marker = new google.maps.Marker({
          position: { lat: parseFloat(place.lat), lng: parseFloat(place.lng) },
          map: this.map,
          title: place.name,
        });

        marker.content =
        `<div class="map-tooltip">
          ${place.image ? `<img src="/${place.image}" width="250px">` : ''}
          <h2>${place.name}</h2>
          <p>
            ${place.phone + (place.phone ? '<br>' : '')}
            ${place.email + (place.email ? '<br>' : '')}
            ${place.address}
          </p>
        </div>`;

        marker.addListener('click', function(showTooltip, marker) {
          return function() {
            showTooltip(marker);
          }
        }(this.showTooltip, marker));

        this.markers.push(marker);
        bounds.extend(marker.getPosition());
      }

      this.map.fitBounds(bounds);

      // $('#map').height($('#map').parent().height());
    }
  },
  watch: {
    offices: {
      handler() {
        this.setupMarkers();
      }
    }
  },
  mounted() {
    this.map = new google.maps.Map(document.getElementById('office-map'), {
      center: {lat: -33.8666, lng: 151.1958},
      zoom: 15
    });

    this.setupMarkers();
  },
  components: {
    'v-page': require('./partials/page')
  }
}
</script>
