document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('precio').addEventListener('input', function () {
        document.getElementById('mostrarPrecio').textContent = this.value + "€";
    });
});