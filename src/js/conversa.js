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
            })
            .catch(error => console.error('Error al cargar los mensajes:', error));
    }

    setInterval(cargarMensajes, 4000);  // Recargar los mensajes cada 4 segundos
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


    const mensajeInput = document.getElementById('mensajeInput');
    const messageForm = document.getElementById('messageForm');

    if (mensajeInput && messageForm) {
        mensajeInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                messageForm.requestSubmit();
            }
        });
    }
});