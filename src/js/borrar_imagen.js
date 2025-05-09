function mostrarImagen(input) {
    const previewPerfil = document.getElementById("preview_perfil");
    const botones = document.getElementById("botones_accion");

    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (!file.type.match("image.*")) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            // Previsualizar imagen en el círculo
            previewPerfil.src = e.target.result;
            botones.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
    }
}

function borrarImagen() {
    const input = document.getElementById("img");
    const previewPerfil = document.getElementById("preview_perfil");
    const botones = document.getElementById("botones_accion");

    input.value = "";
    previewPerfil.src = "/src/img/perfil.png"; // Imagen por defecto
    botones.classList.add("d-none");
}
