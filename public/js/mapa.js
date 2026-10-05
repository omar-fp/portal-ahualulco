var centro = [datosMapa.latitud, datosMapa.longitud];
var mapa = L.map('mapa').setView(centro, 14);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(mapa);

// Marcador en la cabecera municipal
L.marker(centro)
    .addTo(mapa)
    .bindPopup('<strong>Ahualulco de Mercado</strong><br>Cabecera municipal');

if (datosMapa.limite) {
    var contorno = L.geoJSON(datosMapa.limite, {
        style: { color: '#dc3545', weight: 2, dashArray: '5, 6', fillOpacity: 0.05 }
    }).addTo(mapa);

    mapa.fitBounds(contorno.getBounds());
}
