<p>Hola, <strong>{{ $data->name }} </strong> ha enviado una solicitud de presupuesto con los siguientes datos:</p>

@if ($data->contact_method == 'phone')
<p><strong>Teléfono:</strong> {{ $data->contact_value }}</p>
@elseif ($data->contact_method == 'email')
<p><strong>Email:</strong> {{ $data->contact_value }}</p>
@elseif ($data->contact_method == 'whatsapp')
<p><strong>Whatsapp:</strong> {{ $data->contact_value }}</p>
@endif

@if ($data->office != null)
<p><strong>Oficina mas cercana:</strong> {{ $data->office->name }}</p>
@endif

<p><strong>Producto de interes:</strong> {{ $data->product_of_interest }}</p>

@if ($data->message != null && strlen($data->message) > 0)
<p>Con el siguiente mensaje:</p>

<p>
    <i>
    <pre>
      {{ $data->message }}
    </pre>
    </i>
</p>
@endif

<p>Que tenga un buen día.</p>