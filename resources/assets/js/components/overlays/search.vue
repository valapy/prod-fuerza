<template>
  <div class="overlay">
    <div class="search content">
      <div class="logo">
        <img src="/img/btn-search.svg" alt="Buscar" />
      </div>
      <form>
        <div class="form-group">
          <label>Modelo</label>
          <input type="text" v-model="filter.model" />
        </div>
        <div class="clear"></div>
        <div class="form-group">
          <label>Motor</label>
          <select class="selectpicker" v-model="filter.engines" multiple data-actions-box="true">
            <!-- <option value="0">Todos</option> -->
            <option v-for="row in engines" :value="row.id">{{ row.description }}</option>
          </select>
        </div>
        <div class="clear"></div>
        <div class="form-group">
          <label class="text-center">Ruedas</label>
        </div>
        <div class="clear"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label>Delantera</label>
              <select class="selectpicker" v-model="filter.front_tires" multiple data-actions-box="true">
                <!-- <option value="0">Todos</option> -->
                <option v-for="row in tires" :value="row.id">{{ row.description }}</option>
              </select>
            </div>
            <div class="col-md-6">
              <label>Trasera</label>
              <select class="selectpicker" v-model="filter.back_tires" multiple data-actions-box="true">
                <!-- <option value="0">Todos</option> -->
                <option v-for="row in tires" :value="row.id">{{ row.description }}</option>
              </select>
            </div>
          </div>
        </div>
        <div class="clear"></div>
        <div class="form-group">
          <label class="text-center">Frenos</label>
        </div>
        <div class="clear"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label>Delantero</label>
              <select class="selectpicker" v-model="filter.front_brakes" multiple data-actions-box="true">
                <!-- <option value="0">Todos</option> -->
                <option v-for="row in brakes" :value="row.id">{{ row.description }}</option>
              </select>
            </div>
            <div class="col-md-6">
              <label>Trasero</label>
              <select class="selectpicker" v-model="filter.back_brakes" multiple data-actions-box="true">
                <!-- <option value="0">Todos</option> -->
                <option v-for="row in brakes" :value="row.id">{{ row.description }}</option>
              </select>
            </div>
          </div>
        </div>
        <div class="clear"></div>
        <div class="buttons form-group">
          <a @click="submit" href="javascript:;" class="btn btn-submit btn-red float-right opacity">
            Buscar
          </a>
          <a @click="$emit('close')" href="javascript:;" class="btn float-right opacity">
            Cerrar
          </a>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filter: {
        model: '',
        engines: [],
        front_tires: [],
        back_tires: [],
        front_brakes: [],
        back_brakes: [],
      }
    }
  },
  computed: {
    engines() {
      return this.$parent.product_engines || []
    },
    tires() {
      return this.$parent.product_tires || []
    },
    brakes() {
      return this.$parent.product_brakes || []
    },
  },
  props: [],
  methods: {
    submit() {
      var query = {}

      for (var key in this.filter) {
        var value = this.filter[key]
        if (typeof value == 'function' || !value || value.length == 0) continue
        if (value instanceof Array) query[key] = function(value) {
          var result = []

          for (var i in value) if (value[i] && value[i] != "0") result.push(value[i])

          return result.join(',')
        }(value)
        else query[key] = value
      }

      this.$router.push({
        path: '/products',
        query: query,
      })
      this.$emit('close')
    },
    keybind(e) {
      if (e.keyCode === 27) this.$emit('close')
    }
  },
  mounted() {
    document.body.addEventListener('keyup', this.keybind)
    $('.selectpicker').selectpicker({
      deselectAllText: 'Todos',
      selectAllText: 'Todos',
      noneSelectedText: 'Ninguno',
      width: '100%',
    })
  },
  beforeDestroy() {
    document.body.removeEventListener('keyup', this.keybind)
  }
}
</script>