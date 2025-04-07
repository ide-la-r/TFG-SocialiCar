const boxPassword = document.getElementById("box-password");
const boxPasswordValidate = document.getElementById("box-password-validate");

const boxDniText = document.getElementById("box-dni-text");
const selectDni = document.getElementById("type-document");


boxPassword.addEventListener("input", () => {
    boxPasswordValidate.removeAttribute("hidden");
    if (boxPassword.value === "") {
        boxPasswordValidate.setAttribute("hidden", true);
        boxPasswordValidate.value = "";
    }
});


selectDni.addEventListener("change", () => {
    boxDniText.removeAttribute("hidden");
    if (selectDni.value === "dni") {
        boxDniText.setAttribute("placeholder", "Número de DNI*");
    } else if (selectDni.value === "nif") {
        boxDniText.setAttribute("placeholder", "Número de NIF*");
    } else if (selectDni.value === "nie") {
        boxDniText.setAttribute("placeholder", "Número de NIE*");
    } else {
        boxDniText.setAttribute("hidden", true);
    }
});