@extends('layouts.app')

@section('titulo', 'Cambiar contraseña')

@section('contenido')
    <div class="tarjeta">
        <h2>Cambiar mi contraseña</h2>

        <form action="{{ route('admin.contrasena.update') }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <label for="password_actual">Contraseña actual:</label>
            <input type="password" name="password_actual" id="password_actual">

            <label for="password">Contraseña nueva (mínimo 8 caracteres):</label>
            <input type="password" name="password" id="password">

            <label for="password_confirmation">Confirmar contraseña nueva:</label>
            <input type="password" name="password_confirmation" id="password_confirmation">

            <button type="submit" class="boton">Guardar contraseña</button>
        </form>
    </div>
@endsection
