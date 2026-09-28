<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') | Portal Municipal Ahualulco</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('inicio') }}">Home</a>
            <a href="{{ route('seguimiento') }}">Consultar folio</a>
            <a href="{{ route('reportes.create') }}" class="boton-nav">Reportar una falla</a>
        </nav>
    </header>

    <div id="banner">
        <img src="{{ asset('imagenes/letras_ahualulcore.png') }}" alt="Ahualulco de Mercado">
    </div>

    <div class="contenido">
        <aside class="lateral">
            <h3>Redes Sociales</h3>
            <details open>
                <summary>Redes</summary>
                {{-- Facebook de ahualulco --}}
                <a href="https://www.facebook.com/p/Gobierno-de-Ahualulco-2024-2027-61572043035467/" title="Facebook">
                    <img src="{{ asset('imagenes/facebookico.png') }}" alt="Logo Facebook" width="22" height="22">
                </a>
            </details>

            <h3>Formas de Contacto</h3>
            <details open>
                <summary>Contacto</summary>
                <ul>
                    <li>Telefono</li>
                    <li>Correo</li>
                    <li>Direccion</li>
                </ul>
            </details>
        </aside>

        <main class="principal">
            {{-- Mensaje guardado en la sesión (flash) --}}
            @if (session('exito'))
                <div class="alerta exito">
                    {{ session('exito') }}
                    Tu folio de seguimiento es: <strong>{{ session('folio') }}</strong>
                </div>
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

            @yield('contenido')
        </main>
    </div>

    <footer>
        <p>Copyright &copy; 2026. H. Ayuntamiento de Ahualulco de Mercado.</p>
        <p class="credito">Proyecto Topicos Selectos ll - Diseño: Figueroa Pérez Omar</p>
    </footer>
</body>
</html>
