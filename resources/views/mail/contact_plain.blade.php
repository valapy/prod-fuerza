Hola, {{ $data->firstname }} {{ $data->lastname }} ha enviado un mail de contacto desde el sitio web con los siguientes datos:

Teléfono: {{ $data->phone }}
Email: {{ $data->email }}

Con el siguiente mensaje:

--
{{ $data->message }}
--

Que tenga un buen día.