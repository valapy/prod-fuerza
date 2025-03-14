<template>
  <div class="form-group" v-if="data !== undefined && data !== null">
    <div class="row">
      <div class="col-xs-5">
        <input
          type="text"
          class="form-control"
          placeholder="Descripción"
          :value="field"
          @input="updateField"
        />
      </div>
      <div class="col-xs-5">
        <input
          type="text"
          class="form-control"
          placeholder="Valor"
          :value="value"
          @input="updateValue"
        />
      </div>
      <div class="col-xs-2 text-right">
        <button type="button" class="btn btn-danger" @click="removeRow">
          <i class="fa fa-trash" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["data"],
  computed: {
    field() {
      return this.$props.data.field;
    },
    value() {
      return this.$props.data.value;
    }
  },
  methods: {
    removeRow() {
      this.$emit("remove");
    },
    updateField(e) {
      const field = e.target.value;
      this.$emit("input", { ...this.$props.data, field });
    },
    updateValue(e) {
      const { value } = e.target;
      this.$emit("input", { ...this.$props.data, value });
    }
  },
};
</script>
