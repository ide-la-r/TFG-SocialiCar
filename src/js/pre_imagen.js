document.addEventListener("DOMContentLoaded", () => {  
    const input = document.getElementById("img");
    const output = document.getElementById("mostrar_img");
  
    if (!input || !output) {
      console.error("No se encontró el input o el output");
      return;
    }
  
    input.addEventListener("change", (evt) => {
      output.innerHTML = "";
      const files = evt.target.files;
  
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (!file.type.match("image.*")) continue;
  
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = document.createElement("img");
          img.src = e.target.result;
          img.className = "me-2";
          img.style.width = "200px";
          output.appendChild(img);
        };
        reader.readAsDataURL(file);
      }
    });
  });