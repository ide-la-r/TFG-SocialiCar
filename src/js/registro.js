document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("tipoIdentificacion");
    const inputIdentificacion = document.getElementById("identificacion");
    const textIdentificacion = document.getElementById("textIdentificacion");
    const inputContrasena = document.getElementById("contrasena");
    const inputConfirmarContrasena = document.getElementById("validarContrasena");
    const textContrasena = document.getElementById("textValidarContrasena");

    function toggleIdentificacion() {
        if (select.value === "dni" || select.value === "nie" || select.value === "nif") {
            inputIdentificacion.removeAttribute("hidden");
            textIdentificacion.innerHTML = "Número de Identificación";
        } else {
            inputIdentificacion.setAttribute("hidden", true);
            textIdentificacion.innerHTML = "";
            inputIdentificacion.value = "";
        }
    }

    

    function toggleConfirmarContrasena() {
        if (inputContrasena.value.trim() !== "") {
            inputConfirmarContrasena.removeAttribute("hidden");
            textContrasena.innerHTML = "Confirmar Contraseña";
        } else {
            inputConfirmarContrasena.setAttribute("hidden", true);
            textContrasena.innerHTML = "";
            inputConfirmarContrasena.value = "";
        }
    }

    select.addEventListener("change", toggleIdentificacion);
    inputContrasena.addEventListener("input", toggleConfirmarContrasena);

    toggleIdentificacion();
    toggleConfirmarContrasena();
});