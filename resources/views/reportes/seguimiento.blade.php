@extends('layouts.app')

@section('titulo', 'Seguimiento de reporte')

@section('contenido')
    <div class="tarjeta">
        <h2>Seguimiento de reporte</h2>

        <form action="{{ route('seguimiento') }}" method="GET">
            <label for="folio">Folio (8 caracteres):</label>
            <input type="text" name="folio" id="folio" maxlength="8" value="{{ $folio != '' ? $folio : session('ultimo_folio') }}">
            <button type="submit" class="boton">Consultar</button>
        </form>

        @if ($buscado && $reporte == null)
            <div class="alerta error">No se encontró ningún reporte con el folio {{ $folio }}.</div>
        @endif

        @if ($reporte != null)
            <div class="resultado">
                <p><strong>Folio:</strong> {{ $reporte->folio }}</p>
                <p><strong>Estado:</strong> {{ $reporte->nombreEstado() }}</p>
                <p><strong>Tipo de problema:</strong> {{ $reporte->tipo->nombre }}</p>
                <p><strong>Ubicación:</strong> {{ $reporte->calle }}, {{ $reporte->colonia->colonias }}</p>
                <p><strong>Descripción:</strong> {{ $reporte->descripcion }}</p>
                <p><strong>Fecha:</strong> {{ $reporte->created_at->format('d/m/Y H:i') }}</p>
            </div>
        @endif
    </div>
@endsection
