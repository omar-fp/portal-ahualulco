@extends('layouts.app')

@section('titulo', 'Agregar administrador')

@section('contenido')
    <div class="tarjeta">
        <h2>Agregar administrador</h2>

        <form action="{{ route('admin.administradores.store') }}" method="POST" novalidate>
            @csrf

            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">

            <label for="email">Correo:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">

            <label for="password">Contraseña (mínimo 8 caracteres):</label>
            <input type="password" name="password" id="password">

            <label for="password_confirmation">Confirmar contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation">

            <label for="rol">Tipo de administrador:</label>
            <select name="rol" id="rol">
                <option value="area" {{ old('rol') == 'area' ? 'selected' : '' }}>De área</option>
                <option value="super" {{ old('rol') == 'super' ? 'selected' : '' }}>General</option>
            </select>

            <label for="tipo_reporte_id">Tipo de reporte:</label>
            <select name="tipo_reporte_id" id="tipo_reporte_id">
                <option value="">-- Selecciona --</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo_reporte_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                @endforeach
            </select>

            <button type="submit" class="boton">Guardar administrador</button>
        </form>
    </div>
@endsection
