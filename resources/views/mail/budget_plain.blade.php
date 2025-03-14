Hola, {{ $data->name }} ha enviado una solicitud de presupuesto con los siguientes datos:

@if ($data->contact_method == 'phone')
Teléfono: {{ $data->contact_value }}
@elseif ($data->contact_method == 'email')
Email: {{ $data->contact_value }}
@elseif ($data->contact_method == 'whatsapp')
Whatsapp: {{ $data->contact_value }}
@endif

@if ($data->office != null)
Oficina mas cercana: {{ $data->office->name }}
@endif

Producto de interes: {{ $data->product_of_interest }}

@if ($data->message != null && strlen($data->message) > 0)
Con el siguiente mensaje:

{{ $data->message }}
@endif

Que tenga un buen día.