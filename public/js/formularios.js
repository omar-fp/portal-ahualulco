// ---------- Formulario de reportes ----------
var formReporte = document.getElementById('form-reporte');

if (formReporte) {
    // id del campo y nombre que se muestra en el aviso
    var camposReporte = [
        { id: 'tipo_reporte_id', nombre: 'Tipo de problema' },
        { id: 'nombre_ciudadano', nombre: 'Tu nombre' },
        { id: 'calle', nombre: 'Calle' },
        { id: 'colonia_id', nombre: 'Colonia' },
        { id: 'descripcion', nombre: 'Descripción del problema' }
    ];

    formReporte.addEventListener('submit', function (evento) {
        var faltantes = [];

        camposReporte.forEach(function (campo) {
            var elemento = document.getElementById(campo.id);

            if (elemento.value.trim() === '') {
                faltantes.push(campo.nombre);
                elemento.classList.add('campo-vacio');
            } else {
                elemento.classList.remove('campo-vacio');
            }
        });

        // Si falta algo se detiene el envío y se muestra el aviso
        if (faltantes.length > 0) {
            evento.preventDefault();
            alert('Faltan campos por llenar:\n\n- ' + faltantes.join('\n- '));
        }
    });

    // Quita el borde rojo cuando el usuario corrige el campo
    camposReporte.forEach(function (campo) {
        var elemento = document.getElementById(campo.id);

        elemento.addEventListener('input', function () {
            elemento.classList.remove('campo-vacio');
        });
        elemento.addEventListener('change', function () {
            elemento.classList.remove('campo-vacio');
        });
    });
}

// ---------- Buscador de folio ----------
var formFolio = document.getElementById('form-folio');

if (formFolio) {
    formFolio.addEventListener('submit', function (evento) {
        var campoFolio = document.getElementById('folio');
        var folio = campoFolio.value.trim();

        if (folio === '') {
            evento.preventDefault();
            campoFolio.classList.add('campo-vacio');
            alert('Escribe el folio de tu reporte.');
        } else if (folio.length !== 8) {
            evento.preventDefault();
            campoFolio.classList.add('campo-vacio');
            alert('El folio debe tener 8 caracteres.');
        } else {
            campoFolio.classList.remove('campo-vacio');
        }
    });
}
