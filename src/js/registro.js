const contrasena = document.getElementById("contrasena");
const validarContrasena = document.getElementById("validarContrasena");

const tipoIdentificacion = document.getElementById("tipoIdentificacion");
const identificacion = document.getElementById("identificacion");


boxPassword.addEventListener("input", () => {
    validarContrasena.removeAttribute("hidden");
    if (boxPassword.value === "") {
        validarContrasena.setAttribute("hidden", true);
        validarContrasena.value = "";
    }
});


identificacion.addEventListener("change", () => {
    tipoIdentificacion.removeAttribute("hidden");
    if (identificacion.value === "dni") {
        tipoIdentificacion.setAttribute("placeholder", "Número de DNI*");
    } else if (identificacion.value === "nif") {
        tipoIdentificacion.setAttribute("placeholder", "Número de NIF*");
    } else if (identificacion.value === "nie") {
        tipoIdentificacion.setAttribute("placeholder", "Número de NIE*");
    } else {
        tipoIdentificacion.setAttribute("hidden", true);
    }
});