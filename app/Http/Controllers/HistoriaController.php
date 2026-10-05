<?php

namespace App\Http\Controllers;

class HistoriaController extends Controller
{
    // Muestra la página de historia del municipio
    public function index()
    {
        // Cronología de hechos: año y descripción
        $cronologia = [
            ['1531', 'Juan de Escárcena llevó a cabo la fundación hispánica.'],
            ['1810', '13 de noviembre. El párroco José María Mercado proclamó la Independencia, uniéndose así al movimiento insurgente encabezado por Miguel Hidalgo.'],
            ['1844', '8 de abril. Por decreto número 5 se estableció ayuntamiento en Ahualulco.'],
            ['1846', '19 de diciembre. Se le dio el nombre de Ahualulco de Mercado en homenaje al insurgente José María Mercado.'],
            ['1858', '21 de mayo. El Coronel conservador Manuel Piélago fusiló en este lugar al liberal Dr. Ignacio Herrera y Cairo retirado de la política.'],
            ['1858', 'El Gral. Miramón derrotó en este sitio al Gral. Santos Degollado.'],
            ['1973', '13 de septiembre. Por decreto número 9,000 la población de Ahualulco fue elevada a la categoría de ciudad.'],
        ];

        return view('historia', compact('cronologia'));
    }
}
