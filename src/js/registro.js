document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("tipoIdentificacion");
    const inputIdentificacion = document.getElementById("identificacion");
    const inputContrasena = document.getElementById("contrasena");
    const inputConfirmarContrasena = document.getElementById("validarContrasena");

    function toggleIdentificacion() {
        if (select.value === "dni" || select.value === "nie" || select.value === "nif") {
            inputIdentificacion.removeAttribute("hidden");
        } else {
            inputIdentificacion.setAttribute("hidden", true);
        }
    }

    function toggleConfirmarContrasena() {
        if (inputContrasena.value.trim() !== "") {
            inputConfirmarContrasena.removeAttribute("hidden");
        } else {
            inputConfirmarContrasena.setAttribute("hidden", true);
        }
    }

    select.addEventListener("change", toggleIdentificacion);
    inputContrasena.addEventListener("input", toggleConfirmarContrasena);

    toggleIdentificacion();
    toggleConfirmarContrasena();
});