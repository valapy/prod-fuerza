<div id="app-specs">
  <input ref="data" name="specs" id="specs" type="hidden" value="<?=isset($data) && $data->specs !== "" ? htmlentities($data->specs) : "[]"?>" />
  <v-section
    v-for="(row, index) in sections"
    :data="row"
    @input="value => updateSection(index, value)"
    @remove="removeSection(index)"
    :key="row.id"
  ></v-section>
  <div class="form-group">
    <button type="button" class="btn btn-default" @click="addSection('')">Agregar</button>
  </div>
</div>