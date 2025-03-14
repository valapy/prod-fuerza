<div class="row">
  <div class="col-md-6">
    <input type="hidden" class="form-control" name="{{ $table }}_attributes[][description]" value="">
  </div>
  <div class="col-md-6">
    <input type="text" class="form-control" name="{{ $table }}_attributes[][value]" value="<?=isset($row)? $row->value : ""?>">
  </div>
</div>