{{-- Mensajes --}}
@if (session('exito'))
    <div class="alerta exito">
        {{ session('exito') }}
        Tu folio de seguimiento es: <strong>{{ session('folio') }}</strong>
    </div>
@endif

@if (session('error'))
    <div class="alerta error">{{ session('error') }}</div>
@endif

{{-- Errores de validación --}}
@if ($errors->any())
    <div class="alerta error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
