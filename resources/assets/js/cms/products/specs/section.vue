<template>
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="row">
        <div class="col-xs-10">
          <input
            type="text"
            class="form-control"
            placeholder="Categoría"
            :value="section"
            @input="updateSection"
          />
        </div>
        <div class="col-xs-2 text-right">
          <button type="button" class="btn btn-danger" @click="removeSection">
            <i class="fa fa-trash" />
          </button>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-xs-10 col-xs-offset-2">
          <v-field
            v-for="(row, index) in fields"
            :data="row || {}"
            :key="row.id"
            @remove="removeField(index)"
            @input="field => updateField(index, field)"
          ></v-field>
        </div>
      </div>
      <div class="form-group">
        <button type="button" class="btn btn-default" @click="addField">Agregar nuevo Campo</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["data"],
  computed: {
    fields() {
      return this.$props.data.data || [];
    },
    section() {
      return this.$props.data.section;
    },
  },
  methods: {
    addField() {
      this.updateFields([...this.fields, { id: this.fields.length, field: "", value: "" }]);
    },
    removeField(i) {
      const fields = [...this.fields];
      fields.splice(i, 1);
      this.updateFields(fields);
    },
    removeSection() {
      this.$emit("remove");
    },
    updateField(i, field) {
      const fields = [...this.fields];
      fields[i] = field;
      this.updateFields(fields);
    },
    updateFields(data) {
      this.$emit("input", { ...this.$props.data, data });
    },
    updateSection(e) {
      const section = e.target.value;
      this.$emit("input", { ...this.$props.data, section });
    }
  },
  components: {
    "v-field": require("./field")
  }
};
</script>
