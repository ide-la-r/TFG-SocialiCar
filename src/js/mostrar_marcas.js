document.addEventListener('DOMContentLoaded', function () {
    const marcaSelect = document.getElementById('marca');
    const modeloSelect = document.getElementById('modelo');

    marcaSelect.addEventListener('change', function () {
        const marca = this.value;

        if (marca !== '') {
            fetch('/socialicar/src/pages/coche/obtener_modelos.php?marca=' + encodeURIComponent(marca))
                .then(response => response.json())
                .then(data => {
                    // Limpiar opciones anteriores
                    modeloSelect.innerHTML = '<option disabled selected hidden>Modelo*</option>';

                    data.forEach(modelo => {
                        const option = document.createElement('option');
                        option.value = modelo;
                        option.textContent = modelo;
                        modeloSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar modelos:', error);
                });
        } else {
            modeloSelect.innerHTML = '<option disabled selected hidden>Modelo*</option>';
        }
    });
});