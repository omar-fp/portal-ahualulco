<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de atención - {{ $reporte->folio }}</title>
    {{-- El PDF se genera con estilos sencillos (no admite flexbox) --}}
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #222; }
        .encabezado { text-align: center; border-bottom: 3px solid #3a87b7; padding-bottom: 10px; margin-bottom: 25px; }
        .encabezado h1 { font-size: 18px; margin: 0 0 4px 0; color: #3a87b7; }
        .encabezado p { margin: 0; color: #555; }
        h2 { font-size: 16px; text-align: center; margin: 0 0 25px 0; }
        .texto { font-size: 15px; line-height: 1.7; text-align: justify; }
        .datos { margin-top: 30px; border-collapse: collapse; width: 100%; }
        .datos td { border: 1px solid #ccc; padding: 6px 10px; font-size: 12px; }
        .datos td.titulo { background: #eaf0f7; font-weight: bold; width: 35%; }
        .pie { margin-top: 40px; text-align: center; font-size: 11px; color: #777; }
    </style>
</head>
<body>
    <div class="encabezado">
        <h1>H. Ayuntamiento de Ahualulco de Mercado</h1>
        <p>Portal municipal de reportes ciudadanos</p>
    </div>

    <h2>Comprobante de atención de reporte</h2>

    <p class="texto">
        El reporte con el folio <strong>{{ $reporte->folio }}</strong> ubicado en la calle
        <strong>{{ $reporte->calle }}</strong> fue atendido el día
        <strong>{{ $reporte->atendido_en->translatedFormat('j \d\e F \d\e Y') }}</strong>.
        Se encontró {{ rtrim($reporte->causa, '.') }}.
    </p>

    <table class="datos">
        <tr><td class="titulo">Folio</td><td>{{ $reporte->folio }}</td></tr>
        <tr><td class="titulo">Tipo de problema</td><td>{{ $reporte->tipo->nombre }}</td></tr>
        <tr><td class="titulo">Colonia</td><td>{{ $reporte->colonia->colonias }}</td></tr>
        <tr><td class="titulo">Fecha del reporte</td><td>{{ $reporte->created_at->format('d/m/Y') }}</td></tr>
        <tr><td class="titulo">Fecha de atención</td><td>{{ $reporte->atendido_en->format('d/m/Y') }}</td></tr>
    </table>

    <p class="pie">Documento generado automáticamente el {{ now()->format('d/m/Y H:i') }}.</p>
</body>
</html>
