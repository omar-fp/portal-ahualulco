@extends('layouts.app')

@section('titulo', 'Reportar una falla')

@section('contenido')
    <div class="tarjeta">
        <h2>Reportar una falla</h2>

        {{-- Validación por parte del Laravel en el servidor --}}
        <form action="{{ route('reportes.store') }}" method="POST" id="form-reporte" novalidate>
            {{-- Protección CSRF --}}
            @csrf

            <label for="tipo_reporte_id">Tipo de problema:</label>
            <select name="tipo_reporte_id" id="tipo_reporte_id">
                <option value="">-- Selecciona --</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo_reporte_id') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>

            <label for="nombre_ciudadano">Tu nombre:</label>
            <input type="text" name="nombre_ciudadano" id="nombre_ciudadano" value="{{ old('nombre_ciudadano') }}">

            <label for="calle">Calle:</label>
            <input type="text" name="calle" id="calle" value="{{ old('calle') }}">

            <label for="colonia_id">Colonia:</label>
            <select name="colonia_id" id="colonia_id">
                <option value="">-- Selecciona --</option>
                @foreach ($colonias as $colonia)
                    <option value="{{ $colonia->id }}" {{ old('colonia_id') == $colonia->id ? 'selected' : '' }}>
                        {{ $colonia->colonias }}
                    </option>
                @endforeach
            </select>

            <label for="descripcion">Descripción del problema:</label>
            <textarea name="descripcion" id="descripcion" rows="5">{{ old('descripcion') }}</textarea>

            <button type="submit" class="boton">Enviar reporte</button>
        </form>
    </div>
@endsection
