<p>Hola, <strong>{{ $data->firstname }} {{ $data->lastname }}</strong> ha enviado un mail de contacto desde el sitio web con los siguientes datos:</p>

<p><strong>Teléfono:</strong> {{ $data->phone }}</p>
<p><strong>Email:</strong> {{ $data->email }}</p>

<p>Con el siguiente mensaje:</p>

<p>
  <i>
    <pre>
      {{ $data->message }}
    </pre>
  </i>
</p>

<p>Que tenga un buen día.</p>