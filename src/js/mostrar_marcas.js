document.addEventListener('DOMContentLoaded', function () {
    const marcaSelect = document.getElementById('marca');
    const modeloSelect = document.getElementById('modelo');

    function cargarModelos(marca, modeloSeleccionado = '') {
        fetch('/src/pages/coche/obtener_modelos.php?marca=' + encodeURIComponent(marca))
            .then(response => response.json())
            .then(data => {
                modeloSelect.innerHTML = '<option value="" disabled selected hidden>Modelo*</option>';

                data.forEach(modelo => {
                    const option = document.createElement('option');
                    option.value = modelo;
                    option.textContent = modelo;
                    if (modelo === modeloSeleccionado) {
                        option.selected = true;
                    }
                    modeloSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar modelos:', error);
            });
    }

    // Cuando cambia la marca manualmente
    marcaSelect.addEventListener('change', function () {
        const marca = this.value;
        if (marca !== '') {
            cargarModelos(marca);
        } else {
            modeloSelect.innerHTML = '<option value="" disabled selected hidden>Modelo*</option>';
        }
    });

    // Si ya hay una marca seleccionada al cargar (tras error de formulario)
    const marcaInicial = marcaSelect.value;
    const modeloInicial = modeloSelect.getAttribute('data-selected');

    if (marcaInicial !== '' && modeloInicial !== null) {
        cargarModelos(marcaInicial, modeloInicial);
    }
});
