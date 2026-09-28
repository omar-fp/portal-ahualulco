<?php

namespace App\Http\Controllers;

class InicioController extends Controller
{
    // Muestra la página principal
    public function index()
    {
        return view('inicio');
    }
}
