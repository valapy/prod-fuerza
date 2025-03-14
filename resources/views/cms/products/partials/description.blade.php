<div id="description-root">
  @component('components.nested_form', [ 'data' => isset($data) ? $data->descriptions() : [], 'table' => 'product_descriptions', 'partial' => 'cms.products.partials.description_form' ])
  @endcomponent
</div>