<template>
  <v-page>
    <div class="content-page">
      <div class="page-header">
        <h1>Productos</h1>
        <div class="container">
          <ul class="filter-list no-list inline-list d-none d-lg-block d-xl-block">
            <li v-if="hasFilters">
              <a href="javascript:;" @click="resetFilters()">Todos</a>
            </li>

            <li v-for="row in categories" v-if="hideCategories" :key="row.id">
              <router-link :to="{ name: 'products', query: { category: row } }" :class="{ active: filter.category == row }">
                {{ row }}
              </router-link>
            </li>

            <li v-if="filter.model" class="text-white">
              Modelo: {{ filter.model }}
            </li>
            <li v-if="!hideCategories && filter.category" class="text-white">
              Categoría: {{ category }}
            </li>
            <li v-if="filter.engines" class="text-white">
              Motor: {{ engines }}
            </li>
            <li v-if="filter.front_tires" class="text-white">
              Rueda delantera: {{ frontTires }}
            </li>
            <li v-if="filter.back_tires" class="text-white">
              Rueda trasera: {{ backTires }}
            </li>
            <li v-if="filter.front_brakes" class="text-white">
              Freno delantero: {{ frontBrakes }}
            </li>
            <li v-if="filter.back_brakes" class="text-white">
              Freno trasero: {{ backBrakes }}
            </li>
          </ul>

          <div class="dropdown d-block d-lg-none d-xl-none">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ hasFilters ? filter.category : 'Buscar' }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a href="javascript:;" @click="resetFilters()" class="dropdown-item router-link-active" v-if="hasFilters">Todos</a>
              <router-link :to="{ name: 'products', query: { category: row } }" v-for="row in categories" class="dropdown-item" :key="row">
                {{ row }}
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <div class="products-list container">
        <transition-group name="fade" tag="div" class="row">
          <div class="col-md-4" v-for="(row, index) in products" v-bind:key="'product' + index">
            <router-link :to="{name: 'product-details', params: params(row) }" class="opacity">
              <img :src="'/' + row.product_image" :alt="row.model" v-if="row.product_image && row.product_image.length > 0" />
              <img src="/img/motorbike_placeholder.svg" :alt="row.model" v-if="!row.product_image || row.product_image.length === 0">
              <p>{{ row.model }}</p>
            </router-link>
          </div>
        </transition-group>
      </div>
    </div>
  </v-page>
</template>

<script>
const slugify =require('slugify');

export default {
  data() {
    return  {
      filter: {},
      filterKeys: [
        'model', 'engines', 'front_tires', 'back_tires', 'front_brakes', 'back_brakes', 'category'
      ]
    }
  },
  // TODO: Fix var not updating
  computed: {
    categories() {
      return this.$parent.product_categories || [];
    },
    products() {
      if (!this.hasFilters) return this.$parent.products
      else return this.$parent.products.filter(product => {
        return (
          (this.filter.category && product.category == this.filter.category) ||
          (this.filter.model && product.model.toLowerCase().search(this.filter.model.toLowerCase()) > -1) ||
          (this.filter.front_tires && this.filter.front_tires.indexOf("" + product.front_tire_id) > -1) ||
          (this.filter.back_tires && this.filter.back_tires.indexOf("" + product.back_tire_id) > -1) ||
          (this.filter.front_brakes && this.filter.front_brakes.indexOf("" + product.front_brake_id) > -1) ||
          (this.filter.back_brakes && this.filter.back_brakes.indexOf("" + product.back_brake_id) > -1) ||
          (this.filter.engines && this.filter.engines.indexOf("" + product.product_engine_id) > -1)
        )
      })
    },
    category() {
      return this.filterList(this.$parent.product_categories, [this.filter.category]).join(', ')
    },
    engines() {
      return this.filterList(this.$parent.product_engines, this.filter.engines).join(', ')
    },
    frontBrakes() {
      return this.filterList(this.$parent.product_brakes, this.filter.front_brakes).join(', ')
    },
    backBrakes() {
      return this.filterList(this.$parent.product_brakes, this.filter.back_brakes).join(', ')
    },
    frontTires() {
      return this.filterList(this.$parent.product_tires, this.filter.front_tires).join(', ')
    },
    backTires() {
      return this.filterList(this.$parent.product_tires, this.filter.back_tires).join(', ')
    },
    hideCategories() {
      let filters = 0
      for (var i in this.filterKeys) if (this.filter[this.filterKeys[i]]) filters++
      return filters == 0 || (filters == 1 && this.filter.category)
    },
    hasFilters() {
      for (var i in this.filterKeys) if (this.filter[this.filterKeys[i]]) return true
      return false
    },
  },
  methods: {
    filterList(list, filter) {
      var result = []
      filter = filter || []

      for (var i in list) {
        var row = list[i]
        if (filter.length == 0) result.push(row.description)
        else if (filter.indexOf(row.id + "") > -1) result.push(row.description)
      }

      return result;
    },
    resetFilters() {
      if (document.location.search.length > 0) this.$router.push('/products')
      else this.filter = {}
    },
    checkFilter() {
      var get = function(key) {
        if (!window.location.search || window.location.search.length == 0) return null
        var query = window.location.search.substring(1)
        var rows = query.split('&')
        for (var i in rows) {
          var pair = rows[i].split('=')
          if (decodeURIComponent(pair[0]) == key) {
            var value = decodeURIComponent(pair[1])
            if (value && value.length > 0) {
              if (value.search(',') > -1) return value.split(',')
              else return value
            }
            else return null
          }
        }
        return null
      }

      this.filter = {}

      for (var i in this.filterKeys) {
        var key = this.filterKeys[i]
        if (get(key)) this.filter[key] = get(key)
      }
    },
    params(product) {
      return {
        slug: slugify(product.model),
        id: product.id,
      }
    }
  },
  watch:{
    $route(to, from){
      this.checkFilter()
    }
  },
  created() {
    this.checkFilter()
  },
  components: {
    'v-page': require('../partials/page')
  }
}
</script>
