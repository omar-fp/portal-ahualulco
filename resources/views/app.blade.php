@extends('layouts.app')

@section('titulo', 'Ubicación')

@push('estilos')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
@endpush

@section('contenido')
    <div class="tarjeta">
        <h2>UBICACIÓN</h2>

        <div id="mapa"></div>

        @if ($mapa['limite'] == null)
            <p class="nota-mapa">No se pudo cargar el contorno del municipio, se muestra solo la cabecera municipal.</p>
        @endif
    </div>

    <div class="tarjeta">
        <h2>Datos del área</h2>
        <p class="texto-justificado">
            Ahualulco de Mercado se localiza en la Región Valles del estado de Jalisco, en el occidente de México.
            Está situado a una altitud promedio de 1,350 metros sobre el nivel del mar, en una zona de transición
            entre el valle y el piedemonte. Su relieve es predominantemente plano, aunque está rodeado por cerros y
            lomeríos que forman parte de la Sierra de Ameca. El municipio cuenta con suelos fértiles, ideales para
            la agricultura, y su clima es templado subhúmedo, con lluvias concentradas principalmente en verano.
            Ahualulco está atravesado por arroyos estacionales y rodeado por paisajes agrícolas y naturales que
            reflejan la riqueza geográfica de la región.
        </p>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        var datosMapa = @json($mapa);
    </script>
    <script src="{{ asset('js/mapa.js') }}"></script>
@endpush
