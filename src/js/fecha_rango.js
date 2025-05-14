document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#fecha_rango", {
        mode: "range", // Modo de selección de rango
        dateFormat: "d-m-Y", // Formato de fecha (día-mes-año)
        minDate: "today", // No se pueden seleccionar fechas pasadas
        locale: "es", // Idioma español (de España)
        onChange: function(selectedDates, dateStr, instance) {
            // Si se seleccionan dos fechas, formateamos el texto
            if (selectedDates.length === 2) {
                // Modificamos el texto para mostrar "hasta" en lugar de "to"
                const fechaInicio = selectedDates[0].toLocaleDateString('es-ES');
                const fechaFin = selectedDates[1].toLocaleDateString('es-ES');
                // Actualizamos el texto del input
                document.getElementById("fecha_rango").value = `Del ${fechaInicio} al ${fechaFin}`;

                // Guardamos las fechas de inicio y fin en los campos ocultos
                document.getElementById("fecha_inicio").value = selectedDates[0].toISOString().split('T')[0];
                document.getElementById("fecha_fin").value = selectedDates[1].toISOString().split('T')[0];
            }
        }
    });
});