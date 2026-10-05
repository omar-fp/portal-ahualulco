@extends('layouts.app')

@section('titulo', 'Historia')

@section('contenido')
    <div class="tarjeta">
        <div class="bloque-historia">
            <img src="{{ asset('imagenes/pasadoahualulco.jpg') }}" alt="Ahualulco del pasado">
            <div>
                <h2>Historia</h2>
                <p>
                    En la época prehispánica fue cacicazgo perteneciente al tlatoanazgo de Etzatlán, habitado por los
                    tochos. Fue gobernado por el guerrero Guajotzin o Huejotzin. El poblado fue incendiado por los
                    tarascos en 1510. Hacia 1524, su territorio fue conquistado por Francisco Cortés de San
                    Buenaventura. En 1531 el lugar fue repoblado por el encomendero de Etzatlán, Juan de Escárcena; y
                    en 1532 su encomendero fue Benito Gallego. La evangelización de este lugar es obra de los frailes
                    Francisco Lorenzo, Antonio Cuellar y Andrés de Córdoba. El virrey Antonio de Mendoza pernoctó en
                    Ahualulco, en enero de 1542; regresando del 8 al 11 de febrero de ese mismo año. A finales del
                    siglo XVI, en el año 1594, se fundó su convento franciscano. La parroquia se empezó a construir en
                    1638 habiéndose terminado en 1760. El día 13 de noviembre de 1810, el párroco de Ahualulco, José
                    María Mercado secundó la causa de Miguel Hidalgo; proclamando la Independencia y uniéndose así al
                    movimiento insurgente.
                </p>
                <p>
                    El 8 de abril de 1844, por decreto número 5 se estableció ayuntamiento, constituyéndose Ahualulco
                    en municipio. Un par de años más tarde, el 19 de diciembre de 1846 se le dio el nombre de
                    Ahualulco de Mercado en recuerdo del héroe insurgente cura José María Mercado. Ese mismo año, en
                    el mes de septiembre, se consideró a Ahualulco como cabecera del 5° Cantón del estado y en
                    octubre pasó a ser cabecera de uno de los 28 departamentos de Jalisco. El poblado ostenta doble
                    título de ciudad, el primero se le confirió el 3 de marzo de 1891, por decreto número 459; y el
                    segundo el 13 de septiembre de 1973 por decreto número 9,000.
                </p>
            </div>
        </div>
    </div>

    <div class="tarjeta">
        <div class="bloque-historia">
            <div>
                <h2>Actualidad</h2>
                <p>
                    Ahualulco de Mercado en la actualidad se ha consolidado como un municipio en desarrollo dentro del
                    estado de Jalisco. Su economía se basa principalmente en la agricultura, el comercio local y
                    pequeñas industrias. El municipio ha experimentado mejoras en infraestructura, servicios públicos
                    y educación, lo que ha contribuido al bienestar de sus habitantes. Además, mantiene vivas sus
                    tradiciones a través de festividades religiosas, ferias y actividades culturales que fortalecen la
                    identidad de su gente. Aunque conserva su esencia rural, Ahualulco de Mercado ha sabido adaptarse
                    a los cambios del siglo XXI, buscando un equilibrio entre modernización y preservación de su
                    herencia histórica.
                </p>
            </div>
            <img src="{{ asset('imagenes/ahualulcopresente.jpg') }}" alt="Ahualulco del presente">
        </div>
    </div>

    <div class="tarjeta">
        <h2>Cronología de hechos</h2>
        <table class="tabla-cronologia">
            {{-- $cronologia viene de HistoriaController --}}
            @foreach ($cronologia as $hecho)
                <tr>
                    <td>{{ $hecho[0] }}</td>
                    <td>{{ $hecho[1] }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
