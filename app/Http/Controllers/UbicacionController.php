<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UbicacionController extends Controller
{
    // Coordenadas de la cabecera municipal 
    private $latitud = 20.7019;
    private $longitud = -103.9736;

    // Muestra el mapa del municipio
    public function index()
    {
        $mapa = [
            'latitud'  => $this->latitud,
            'longitud' => $this->longitud,
            'limite'   => $this->buscarLimite(),
        ];

        return view('ubicacion', compact('mapa'));
    }


    private function buscarLimite()
    {
        return Cache::remember('limite_ahualulco', now()->addDay(), function () {
            try {
                $respuesta = Http::withHeaders(['User-Agent' => 'PortalAhualulco/1.0 (proyecto escolar CUValles)'])
                    ->timeout(5)
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'q'               => 'Ahualulco de Mercado, Jalisco, México',
                        'format'          => 'jsonv2',
                        'polygon_geojson' => 1,
                        'limit'           => 5,
                    ]);

                if ($respuesta->failed()) {
                    Log::warning('La API de Nominatim respondió con error', ['codigo' => $respuesta->status()]);
                    return null;
                }

                foreach ($respuesta->json() as $lugar) {
                    $tipo = $lugar['geojson']['type'] ?? '';

                    if ($tipo == 'Polygon' || $tipo == 'MultiPolygon') {
                        return $lugar['geojson'];
                    }
                }

                Log::warning('Nominatim no regresó el contorno del municipio');
            } catch (\Exception $e) {
                Log::warning('No se pudo consultar la API de Nominatim', ['error' => $e->getMessage()]);
            }

            return null;
        });
    }
}
