document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("autocomplete");
    const sugerencias = document.getElementById("sugerencias");

    input.addEventListener("input", function () {
        const query = input.value.trim();
        if (query.length < 3) {
            sugerencias.innerHTML = "";
            return;
        }

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', España')}&addressdetails=1&limit=5&countrycodes=es`)
            .then(res => res.json())
            .then(data => {
                sugerencias.innerHTML = "";

                if (data.length === 0) {
                    const noResult = document.createElement("div");
                    noResult.classList.add("list-group-item", "text-muted");
                    noResult.textContent = "No se encontraron resultados.";
                    sugerencias.appendChild(noResult);
                    return;
                }

                data.forEach(lugar => {
                    const item = document.createElement("a");
                    item.classList.add("list-group-item", "list-group-item-action");
                    item.textContent = lugar.display_name;
                    item.href = "#";
                    item.addEventListener("click", function (e) {
                        e.preventDefault();
                        input.value = lugar.display_name;
                        document.getElementById("lat").value = lugar.lat;
                        document.getElementById("lon").value = lugar.lon;
                        sugerencias.innerHTML = "";
                    });
                    sugerencias.appendChild(item);
                });
            })
            .catch(error => {
                console.error("Error al obtener las direcciones:", error);
                sugerencias.innerHTML = "<div class='list-group-item text-danger'>Error al cargar sugerencias.</div>";
            });
    });

    document.addEventListener("click", function (e) {
        if (!sugerencias.contains(e.target) && e.target !== input) {
            sugerencias.innerHTML = "";
        }
    });
});
