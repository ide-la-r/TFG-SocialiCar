document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("tipoIdentificacion");
    const inputIdentificacion = document.getElementById("identificacion");

    function toggleInput() {
        if (select.value === "dni" || select.value === "nie" || select.value === "nif") {
            inputIdentificacion.removeAttribute("hidden");
        } else {
            inputIdentificacion.setAttribute("hidden", true);
        }
    }

    select.addEventListener("change", toggleInput);

    toggleInput();
});