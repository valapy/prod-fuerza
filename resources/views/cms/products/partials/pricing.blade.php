<div id="app-pricing">
  <input ref="data" name="pricing" id="pricing" type="hidden" value='<?=isset($data) && $data->pricing !== "" ? $data->pricing : "[]"?>' />
  <div class="form-group">
    <label>Precio al contado</label>
    <input class="form-control editor" type="text" name="spot_price" value="<?=isset($data)? $data->spot_price : ""?>" />
  </div>
  <div class="form-group">
    <label>Requisitos para la financiación</label>
    <textarea class="form-control editor" name="financing_requirements"><?=isset($data)? $data->financing_requirements : ""?></textarea>
  </div>
  <div class="form-group">
    <label>Planes de financiación</label>
    <v-row
      v-for="(row, index) in pricing"
      :data="row"
      @input="value => update(index, value)"
      @remove="remove(index)"
      @move="direction => move(direction, index)"
      :key="`pricing-${row.id}`"
    ></v-row>
  </div>
  <div class="form-group">
    <button type="button" class="btn btn-default" @click="add()">Agregar</button>
  </div>
</div>
