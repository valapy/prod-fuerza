<template>
  <div class="form-group" v-if="data !== undefined && data !== null">
    <div class="row">
      <div class="col-xs-1">
        <div class="btn-group-vertical">
          <button class="btn btn-move" type="button" @click="$emit('move', 'up')">
            <span class="fa fa-arrow-up"></span>
          </button>
          <button class="btn btn-move" type="button" @click="$emit('move', 'down')">
            <span class="fa fa-arrow-down"></span>
          </button>
        </div>
      </div>
      <div class="col-xs-5">
        <input
          type="text"
          class="form-control"
          placeholder="Descripción"
          :value="field"
          @input="e => update(e.target.value, value)"
        />
      </div>
      <div class="col-xs-4">
        <input
          type="text"
          class="form-control"
          placeholder="Precio"
          :value="value"
          @input="e => update(field, e.target.value)"
        />
      </div>
      <div class="col-xs-2 text-right">
        <button type="button" class="btn btn-danger" @click="$emit('remove')">
          <i class="fa fa-trash" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["data"],
  data() {
    return {
      field: this.$props.data.field || '',
      value: this.$props.data.value || '',
    }
  },
  methods: {
    update(field, value) {
      this.field = field;
      this.value = value;
      this.$emit("input", { ...this.$props.data, field, value });
    },
  },
};
</script>

<style scoped>
.btn-move {
  line-height: 16px;
  padding-top: 0;
  padding-bottom: 0;
}

.btn-move .fa {
  font-size: 12px;
}
</style>
