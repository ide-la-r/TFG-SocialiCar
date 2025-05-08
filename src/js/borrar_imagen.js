function mostrarImagen(input) {
    const output = document.getElementById("mostrar_img");
    const botones = document.getElementById("botones_accion");
    output.innerHTML = "";
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (!file.type.match("image.*")) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement("img");
            img.src = e.target.result;
            img.className = "me-2 rounded";
            img.style.width = "200px";
            output.appendChild(img);
            botones.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
    }
}

function borrarImagen() {
    const input = document.getElementById("img");
    const output = document.getElementById("mostrar_img");
    const botones = document.getElementById("botones_accion");
    
    input.value = "";
    output.innerHTML = "";
    botones.classList.add("d-none");
}