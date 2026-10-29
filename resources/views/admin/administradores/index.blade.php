@extends('layouts.app')

@section('titulo', 'Administradores')

@section('contenido')
    <div class="tarjeta">
        <h2>Administradores</h2>

        <a href="{{ route('admin.administradores.create') }}" class="boton">Agregar administrador</a>

        <div class="tabla-scroll">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Tipo</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($administradores as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @if ($admin->esSuper())
                                    General (todos los reportes)
                                @else
                                    {{ $admin->tipoReporte->nombre }}
                                @endif
                            </td>
                            <td>
                                @if ($admin->id == auth()->user()->id)
                                    Tu cuenta
                                @else
                                    <form action="{{ route('admin.administradores.destroy', $admin) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar al administrador {{ $admin->email }}? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="boton-chico boton-peligro">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection