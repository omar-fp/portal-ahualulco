@extends('layouts.app')

@section('titulo', 'Panel de reportes')

@section('contenido')
    <div class="tarjeta">
        <h2>
            Reportes
            @if (! auth()->user()->esSuper())
                de {{ auth()->user()->tipoReporte->nombre }}
            @endif
        </h2>

        <form action="{{ route('admin.reportes.index') }}" method="GET" class="filtro">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado">
                <option value="">Todos</option>
                @foreach ($estados as $clave => $texto)
                    <option value="{{ $clave }}" {{ request('estado') == $clave ? 'selected' : '' }}>{{ $texto }}</option>
                @endforeach
            </select>
            <button type="submit" class="boton-chico">Filtrar</button>
        </form>

        @if ($reportes->isEmpty())
            <p>No hay reportes para mostrar.</p>
        @else
            <p>Total de reportes: <strong>{{ $reportes->total() }}</strong></p>

            <div class="tabla-scroll">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Tipo</th>
                            <th>Ubicación</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            @if (auth()->user()->esSuper())
                                <th>Eliminar</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reportes as $reporte)
                            <tr>
                                <td>{{ $reporte->folio }}</td>
                                <td>{{ $reporte->tipo->nombre }}</td>
                                <td>{{ $reporte->calle }}, {{ $reporte->colonia->colonias }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($reporte->descripcion, 60) }}</td>
                                <td>{{ $reporte->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.reportes.estado', $reporte) }}" method="POST" class="form-estado">
                                        @csrf
                                        @method('PATCH')
                                        <select name="estado">
                                            @foreach ($estados as $clave => $texto)
                                                <option value="{{ $clave }}" {{ $reporte->estado == $clave ? 'selected' : '' }}>{{ $texto }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="boton-chico">Guardar</button>
                                    </form>
                                </td>
                                @if (auth()->user()->esSuper())
                                    <td>
                                        @if ($reporte->estado == 'atendido')
                                            <form action="{{ route('admin.reportes.destroy', $reporte) }}" method="POST"
                                                  onsubmit="return confirm('¿Eliminar el reporte {{ $reporte->folio }}? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="boton-chico boton-peligro">Eliminar</button>
                                            </form>
                                        @else
                                            —
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $reportes->links('partials.paginacion') }}
        @endif
    </div>
@endsection
