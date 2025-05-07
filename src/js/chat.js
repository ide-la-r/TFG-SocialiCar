document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('chat-container');
    const id_mensaje_saliente = container.getAttribute('data-id-saliente');
    const id_mensaje_entrante = container.getAttribute('data-id-entrante');
    const chatBox = document.querySelector('.chat-box');
    const inputField = document.querySelector('.input-field');
    const typingArea = document.querySelector('.typing-area');

    // Prevenir que el dueño se escriba a sí mismo
    if (id_mensaje_saliente === id_mensaje_entrante) {
        alert("No puedes enviarte mensajes a ti mismo.");
        typingArea.style.display = 'none';  // Ocultar el formulario de chat si es el dueño
        return;  // Detener el script
    }

    // Función para cargar los mensajes
    function cargarMensajes() {
        fetch(`get_messages.php?id_mensaje_saliente=${id_mensaje_saliente}&id_mensaje_entrante=${id_mensaje_entrante}`)
            .then(response => response.text())
            .then(data => {
                chatBox.innerHTML = data;  // Cargar los mensajes en el contenedor
                chatBox.scrollTop = chatBox.scrollHeight;  // Mantener el scroll en el fondo
                console.log('Mensajes cargados:', data);  // Ver en la consola si los mensajes se cargan correctamente
            })
            .catch(error => console.error('Error al cargar los mensajes:', error));
    }

    setInterval(cargarMensajes, 3000);  // Recargar los mensajes cada 3 segundos
    cargarMensajes();  // Llamar una vez al cargar la página

    // Manejar el envío de mensajes
    typingArea.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir que el formulario recargue la página

        const mensaje = inputField.value.trim();
        if (mensaje === "") return;  // Evitar enviar mensajes vacíos

        const formData = new FormData();
        formData.append('mensaje', mensaje);
        formData.append('id_mensaje_entrante', id_mensaje_entrante);
        formData.append('id_mensaje_saliente', id_mensaje_saliente);

        fetch('send_message.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            inputField.value = '';  // Limpiar el campo de mensaje
            cargarMensajes();  // Recargar los mensajes
        })
        .catch(error => console.error('Error al enviar el mensaje:', error));
    });
});