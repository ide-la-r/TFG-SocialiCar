import { config } from '../config/config.js';

const apiKey = config.API_KEY;

// Elementos del DOM
const chatToggleButton = document.getElementById('chat-toggle');
const chatWidget = document.getElementById('chat-widget');
const userInput = document.getElementById('user-input');
const messagesContainer = document.getElementById('messages');
const sendButton = document.getElementById('send-btn');

// Historial de la conversación (contexto)
let chatHistory = [
    {
        role: 'system',
        content: `Eres un asistente virtual conversacional y amable de SocialiCar, una plataforma de alquiler de coches entre particulares. 
Responde paso a paso y guía al usuario como lo haría un chatbot profesional como el de Amovens. 
Si te preguntan por coches, primero pregunta si son propietarios o arrendatarios. 
No respondas a preguntas que no estén relacionadas con SocialiCar.`
    }
];

// Función para mostrar un mensaje en el chat
function appendMessage(role, content) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', role);
    messageDiv.innerHTML = `${content}`;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Función para enviar el mensaje al modelo de OpenAI o responder directamente si pregunta por coches baratos
async function sendMessageToOpenAI(message) {
    chatHistory.push({ role: 'user', content: message });

    const lowerMessage = message.toLowerCase();

    // Comprobar si la consulta es sobre coches baratos
    const palabrasClaveCochesBaratos = [
        'coche barato',
        'coches baratos',
        'coche económico',
        'coche más barato',
        'alquiler barato',
        'rentar coche barato',
        'alquilar coche barato' // Eliminadas frases genéricas
    ];

    // Responder sobre alquilar el coche del usuario (ahora antes que coches baratos)
    const frasesAlquilarPropio = [
        'como alquilo mi coche',
        'cómo alquilo mi coche',
        'alquilar mi coche',
        'quiero alquilar mi coche',
        'poner mi coche en alquiler',
        'alquilar mi propio coche',
        'alquilar coche propio',
        'rentar mi coche',
        'quiero rentar mi coche',
        'publicar mi coche',
        'subir mi coche',
        'ofrecer mi coche',
        'alquilar coche como propietario',
        'alquilar coche de mi propiedad'
    ];
    const coincideAlquilarPropio = frasesAlquilarPropio.some(frase => lowerMessage.includes(frase));

    if (coincideAlquilarPropio) {
        const respuestaAlquiler = `Para poder alquilar tu coche en SocialiCar, primero debes <a href="https://socialicar.wuaze.com/src/pages/usuario/iniciar_sesion" target="_blank">iniciar sesión</a> en nuestra app o, si no tienes cuenta, <a href="https://socialicar.wuaze.com/src/pages/usuario/registro" target="_blank">registrarte aquí</a>. Una vez hayas iniciado sesión o te hayas registrado, verás en el navbar un botón para poder alquilar tu coche.`;
        appendMessage('assistant', respuestaAlquiler);
        chatHistory.push({ role: 'assistant', content: respuestaAlquiler });
        return;
    }

    // Si el usuario ya está registrado y pregunta qué hacer para alquilar su coche
    const frasesYaRegistrado = [
        'ya estoy registrado',
        'ya tengo cuenta',
        'ahora que hago',
        'qué hago ahora',
        'ya me he registrado',
        'ya estoy dado de alta',
        'ya me registré',
        'ya tengo usuario',
        'ya inicié sesión',
        'ya he iniciado sesión'
    ];
    const coincideYaRegistrado = frasesYaRegistrado.some(frase => lowerMessage.includes(frase));
    // Buscar si el mensaje anterior del bot fue sobre alquilar su coche
    const lastBotMsg = chatHistory.slice().reverse().find(item => item.role === 'assistant');
    if (
        coincideYaRegistrado &&
        lastBotMsg &&
        lastBotMsg.content.toLowerCase().includes('alquilar tu coche')
    ) {
        const respuestaRegistro = `¡Perfecto! Una vez hayas iniciado sesión, verás en el navbar un botón que pone <b>Alquilar coche</b>. Haz clic en ese botón y completa el formulario con los datos de tu coche para ponerlo en alquiler en SocialiCar.`;
        appendMessage('assistant', respuestaRegistro);
        chatHistory.push({ role: 'assistant', content: respuestaRegistro });
        return;
    }

    // Si el mensaje es sobre alquilar un coche (no propio), responder con el enlace y recomendación de filtros
    const frasesAlquilarCoche = [
        'alquilar un coche',
        'quiero alquilar un coche',
        'necesito alquilar un coche',
        'donde puedo alquilar un coche',
        'buscar coche para alquilar',
        'alquiler de coche',
        'alquilar coche para viajar',
        'alquilar coche para irme de viaje',
        'buscar coches disponibles',
        'ver coches para alquilar',
        'coches para alquilar',
        'coches disponibles para alquilar',
        'alquiler de coches',
        'alquilar coche',
        'quiero un coche de alquiler',
        'necesito coche para viajar',
        'donde alquilar coche',
        'alquilar coche barato',
        'coche barato',
        'coches baratos',
        'coche económico',
        'coche más barato',
        'alquiler barato',
        'rentar coche barato'
    ];
    const coincideAlquilarCoche = frasesAlquilarCoche.some(frase => lowerMessage.includes(frase));

    if (coincideAlquilarCoche) {
        const respuesta = `Puedes ver todos los coches disponibles para alquilar en SocialiCar y aplicar filtros para encontrar el que mejor se adapte a tus necesidades en este enlace: <a href="https://socialicar.wuaze.com/src/pages/rentacar/mostrar_coches" target="_blank">Ver coches disponibles</a> 🚗💨. Te recomiendo usar los filtros de búsqueda para ajustar la zona, fechas y tipo de coche que prefieras.`;
        appendMessage('assistant', respuesta);
        chatHistory.push({ role: 'assistant', content: respuesta });
        return;
    }

    // Si el mensaje es sobre coches baratos, responder directamente
    const coincideCochesBaratos = palabrasClaveCochesBaratos.some(frase => lowerMessage.includes(frase));

    if (coincideCochesBaratos) {
        const respuesta = `¡Genial! En SocialiCar tenemos una variedad de coches disponibles para alquilar. Puedes ver todos los coches disponibles y aplicar filtros para encontrar lo que más te convenga en este enlace: <a href="https://socialicar.wuaze.com/src/pages/rentacar/mostrar_coches" target="_blank">Ver coches disponibles</a> 🚗💨`;
        appendMessage('assistant', respuesta);
        chatHistory.push({ role: 'assistant', content: respuesta });
        return;
    }

    // Responder sobre registro de propietario SOLO si la última respuesta fue invitación al registro
    const lastBotMessage = chatHistory.slice().reverse().find(item => item.role === 'assistant');
    if (
        lowerMessage.includes("si") &&
        lastBotMessage &&
        lastBotMessage.content.toLowerCase().includes("registro de propietario")
    ) {
        const registroLink = `Perfecto. Para comenzar, te recomiendo que accedas al siguiente enlace: <a href="https://socialicar.wuaze.com/src/pages/usuario/registro" target="_blank">Registro de propietario</a>. Una vez allí, sigue los pasos para crear tu cuenta como propietario en nuestra plataforma. ¡Espero que te vaya genial alquilando tu coche a través de SocialiCar! ¿Puedo ayudarte con algo más?`;
        appendMessage('assistant', registroLink);
        chatHistory.push({ role: 'assistant', content: registroLink });
        return;
    }

    // Responder sobre iniciar sesión
    if (lowerMessage.includes("iniciar sesión") || lowerMessage.includes("login")) {
        const iniciarSesionLink = `Si ya tienes una cuenta, puedes iniciar sesión aquí: <a href="https://socialicar.wuaze.com/src/pages/usuario/iniciar_sesion" target="_blank">Iniciar sesión</a>`;
        appendMessage('assistant', iniciarSesionLink);
        chatHistory.push({ role: 'assistant', content: iniciarSesionLink });
        return;
    }

    const data = {
        model: 'gpt-3.5-turbo',
        messages: chatHistory,
    };

    try {
        const response = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${apiKey}`,
            },
            body: JSON.stringify(data),
        });

        const responseData = await response.json();
        const assistantMessage = responseData.choices[0].message.content;

        chatHistory.push({ role: 'assistant', content: assistantMessage });
        appendMessage('assistant', assistantMessage);
    } catch (error) {
        console.error('Error:', error);
        appendMessage('assistant', 'Lo siento, ocurrió un error al procesar tu solicitud.');
    }
}

// Manejar clic en el botón de enviar
sendButton.addEventListener('click', () => {
    const userMessage = userInput.value.trim();

    if (userMessage) {
        appendMessage('user', userMessage);
        userInput.value = '';
        sendMessageToOpenAI(userMessage);
    }
});

// Manejar la tecla "Enter" para enviar el mensaje
userInput.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        sendButton.click();
    }
});

// Mostrar mensaje de bienvenida al abrir el widget
chatToggleButton.addEventListener('click', () => {
    if (chatWidget.style.display === 'none' || chatWidget.style.display === '') {
        chatWidget.style.display = 'flex';

        if (!chatWidget.dataset.welcomeShown) {
            const welcomeMessage = '¡Hola! 👋 Soy el asistente virtual de SocialiCar. ¿Eres propietario de un coche o estás buscando alquilar uno?';
            appendMessage('assistant', welcomeMessage);
            chatHistory.push({ role: 'assistant', content: welcomeMessage });
            chatWidget.dataset.welcomeShown = 'true';
        }
    } else {
        chatWidget.style.display = 'none';
    }
});

