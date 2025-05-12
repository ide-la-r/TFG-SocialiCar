document.addEventListener("DOMContentLoaded", function () {
    const mapaDiv = document.getElementById("map");
    const direccion = mapaDiv.getAttribute("data-direccion");

    if (!direccion) {
        console.error("No se encontró la dirección");
        return;
    }

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(direccion)}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                alert("Dirección no encontrada");
                return;
            }

            const lat = data[0].lat;
            const lon = data[0].lon;

            // Crear el mapa centrado en la dirección
            const map = L.map("map").setView([lat, lon], 16);

            // Añadir capa de mapa de OpenStreetMap
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Añadir marcador en la ubicación
            const marker = L.marker([lat, lon]).addTo(map)
                .bindPopup("Zona aproximada de entrega") // Muestra solo el texto
                .openPopup();

            // Añadir un círculo alrededor del punto (zona aproximada)
            const circle = L.circle([lat, lon], {
                color: '#6BBFBF',
                fillColor: '#B0D5D9',
                fillOpacity: 0.2,
                radius: 300 // Radio en metros
            }).addTo(map);

            // Mostrar texto sobre el círculo

        })
        .catch(error => {
            console.error("Error al cargar el mapa:", error);
        });
});
