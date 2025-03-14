<?php $id = str_replace('.', '_', $partial) ?>
<div id="{{ $id }}">
  <div class="list">
    @foreach ($data as $i=>$row)
      <div class="list-item">
        @include($partial, ['data' => $row, 'table' => $table, 'i' => $i])
      </div>
    @endforeach
  </div>
  <button class="btn btn-default btn-add" type="button">Agregar</button>
</div>

@push('js')
<script>
$(function(){
  $('#{{ $id }} .btn-add').on('click', function(e){
    e.preventDefault()
    let $template = "<div class=\"list-item\"><?= strtr(view($partial, ['table' => $table, 'i' => '__INDEX__'])->render(), ["\n" => '', "\r" => '', '"' => '\"']) ?></div>";
    $('#{{ $id }} .list').append(
      $template.replace(new RegExp('__INDEX__', 'g'), $('#{{ $id }} .list').children().length)
    )
    $('#{{ $id }} textarea.editor').trumbowyg({
      btns: [['bold', 'italic'], ['link']],
      autogrow: true,
      autogrowOnEnter: true
    });
  });
  $('#{{ $id }}').on('click', '.btn-delete', function(e){
    e.preventDefault()
    if (confirm('Esta seguro que desea eliminar el registro?')) {
      $parent = $(this).parent()
      if ($parent.find('input[type="hidden"]').length > 0) {
        $parent.hide()
        $parent.find('input._destroy').val(true)
      } else {
        $parent.remove()
      }
    }
  })
})
</script>
@endpush