const mapDiv = document.getElementById("map");
const direccion = mapDiv.dataset.direccion;
fetch("https://nominatim.openstreetmap.org/search?format=json&q=" + encodeURIComponent(direccion))
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lon = parseFloat(data[0].lon);

            const mapa = L.map('map').setView([lat, lon], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://socialicar.wuaze.com/">SocialiCar</a>'
            }).addTo(mapa);

            L.circle([lat, lon], {
                color: '#6BBFBF',
                fillColor: '#B0D5D9',
                fillOpacity: 0.5,
                radius: 500
            }).addTo(mapa).bindPopup("Zona aproximada de recogida/devolución").openPopup();
        } else {
            alert("No se encontró la dirección.");
        }
    })
    .catch(error => {
        console.error("Error al buscar la dirección:", error);
    });