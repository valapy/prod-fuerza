@component('components.nested_form', [ 'data' => isset($data) ? $data->colors()->get() : [], 'table' => 'product_colors', 'partial' => 'cms.products.partials.color_form' ])
@endcomponent
