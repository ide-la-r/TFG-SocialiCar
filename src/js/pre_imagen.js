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

/*   document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("img");
    const output = document.getElementById("mostrar_img");
    const form = document.getElementById("formulario");

    if (!input || !output || !form) {
        console.error("No se encontró el input, output o formulario");
        return;
    }

    let filesArray = [];

    input.addEventListener("change", (evt) => {
        output.innerHTML = "";
        filesArray = Array.from(evt.target.files);

        filesArray.forEach((file, i) => {
            if (!file.type.match("image.*")) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement("div");
                div.className = "preview-img";
                div.style.position = "relative";
                div.style.cursor = "move";
                div.setAttribute('data-index', i); // Guarda el índice original

                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "150px";
                img.style.display = "block";
                img.style.objectFit = "cover";
                div.appendChild(img);

                output.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Hacer el contenedor ordenable
    new Sortable(output, {
        animation: 150,
        onEnd: function (evt) {
            // Actualiza filesArray según el nuevo orden visual
            const previews = Array.from(output.children);
            const newFilesArray = [];
            previews.forEach((preview) => {
                const index = parseInt(preview.getAttribute('data-index'));
                newFilesArray.push(filesArray[index]);
            });
            filesArray = newFilesArray;
        }
    });

    // Envío por AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        // Elimina los archivos originales del input file
        formData.delete('img[]');

        // Añade los archivos en el orden correcto
        filesArray.forEach(file => {
            formData.append('img[]', file);
        });

        fetch('nuevo_coche.php', { // Asegúrate de que esta ruta es correcta
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            // Opcional: recarga o redirige
            //location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}); */