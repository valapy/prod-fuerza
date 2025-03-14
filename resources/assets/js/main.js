require('./bootstrap');
require('bootstrap-select');
require('jquery-touchswipe');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('search-overlay', require('./components/overlays/search'))
Vue.component('budget-overlay', require('./components/overlays/budget'))

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: require('./components/home'),
      alias: '/home'
    },
    {
      path: '/la_empresa',
      name: 'about_us',
      component: require('./components/about_us'),
      alias: '/about_us'
    },
    {
      path: '/contactenos',
      name: 'contact_us',
      component: require('./components/contact_us'),
      alias: '/contact_us'
    },
    {
      path: '/concesionarias',
      name: 'branch_offices',
      component: require('./components/branch_offices'),
      alias: '/branch_offices'
    },
    {
      path: '/servicios_y_repuestos',
      name: 'service',
      component: require('./components/service'),
      alias: '/service'
    },
    {
      path: '/noticias',
      name: 'news',
      component: require('./components/news/index'),
      alias: '/news',
    },
    {
      path: '/noticias/:id',
      name: 'news-details',
      component: require('./components/news/details'),
      alias: '/news/:id'
    },
    {
      path: '/productos',
      name: 'products',
      component: require('./components/products/index'),
      alias: '/products',
    },
    {
      path: '/productos/:id',
      name: 'product-details-legacy',
      component: require('./components/products/details'),
      alias: '/products/:id'
    },
    {
      path: '/productos/:slug/:id',
      name: 'product-details',
      component: require('./components/products/details'),
      alias: '/products/:slug/:id'
    },
    {
      path: '/usados',
      name: 'used-products',
      component: require('./components/products/used/index'),
    },
    {
      path: '/usados/:slug/:id',
      name: 'used-product-details',
      component: require('./components/products/used/details'),
    },
    { path: "*", component: require('./components/404') },
  ]
})

new Vue({
  data: {
    content: {},
    current_product: null,
    branch_offices: [],
    home: {},
    isMainMenuVisible: false,
    garages: [],
    news: [],
    overlay: null,
    products: [],
    product_categories: [],
    product_tires: [],
    product_brakes: [],
    product_engines: [],
    used_products: [],
  },
  methods: {
    showOverlay: function (name) {
      this.overlay = name
    },
    showMenu: function () {
      this.isMainMenuVisible = true;
    },
    hideMenu: function () {
      this.isMainMenuVisible = false;
    },
    step(arr, step, continuousIndices) {
      var result = []
      var index = 0
      for (var i = 0; i < arr.length; i += step) {
        if (continuousIndices) {
          result.push(index)
          index++;
        } else result.push(i)
      }
      return result
    }
  },
  router,
  components: {
    'v-back-to-top': require('./components/partials/top-button')
  },
  created: function () {
    $.ajax({
      url: '/data.json'
    }).done(data => {
      var keys = [
        'content',
        'branch_offices',
        'home',
        'garages',
        'news',
        'products',
        'product_tires',
        'product_engines',
        'product_brakes',
        'product_categories',
        'used_products',
      ]

      for (let key of keys) {
        if (data[key]) this[key] = data[key];
      }

      this.products.sort((a, b) => {
        if (a.category < b.category) {
          return -1;
        } else if (a.category > b.category) {
          return 1;
        }
        
        if (a.model < b.model) {
          return -1;
        } else if (a.model > b.model) {
          return 1;
        } else {
          return 0;
        }
      })
    })
  },
  watch: {
    $route(to, from) {
      $('html, body').animate({ scrollTop: '0px' }, 200);
    }
  },
}).$mount('#app')

$(function () {
  $(".carousel").swipe({
    swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
      if (direction == 'left') $(this).carousel('next');
      if (direction == 'right') $(this).carousel('prev');
    },
    allowPageScroll: "vertical"
  });

  $(document).on('click', 'a[href*="#"]', function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });
})
