@extends('layouts.app')

@section('titulo', 'Acceso de administradores')

@section('contenido')
    <div class="tarjeta">
        <h2>Acceso de administradores</h2>

        <form action="{{ route('login.store') }}" method="POST" novalidate>
            @csrf

            <label for="email">Correo:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password">

            <button type="submit" class="boton">Entrar</button>
        </form>
    </div>
@endsection
