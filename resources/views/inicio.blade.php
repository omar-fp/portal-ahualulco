@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')
    <div class="tarjeta">
        <h2>Noticias Recientes</h2>

        {{-- Por ahora las noticias están escritas aquí directamente.
             Más adelante el administrador las podrá crear y editar desde su panel. --}}
        <article class="noticia">
            <p class="fecha">Abr 24, 2025</p>
            <h3>Firman convenio para fortalecer el desarrollo laboral en Ahualulco.</h3>
        </article>

        <article class="noticia">
            <p class="fecha">May 13, 2025</p>
            <h3>Pozolli 2025: Ahualulco de Mercado celebra con orgullo su tradición y cultura.</h3>
        </article>
    </div>
@endsection
