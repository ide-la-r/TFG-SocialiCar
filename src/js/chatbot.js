let apiKey = null;
(async () => {
    try {
        const module = await import('../config/config.js');
        apiKey = module && module.config && module.config.API_KEY ? module.config.API_KEY : null;
    } catch (e) {
        apiKey = null;
    }
})();

function ensureDOMReady(fn) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        fn();
    }
}

ensureDOMReady(() => {
    // 1. Inyectar CSS si no existe
    if (!document.getElementById('sc-chatbot-style')) {
    const style = document.createElement('style');
    style.id = 'sc-chatbot-style';
    style.innerHTML = `
        #sc-chat-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #6BBFBF;
            color: #F2F2F2;
            padding: 14px 28px;
            border-radius: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            cursor: pointer;
            font-size: 1.3rem;
            z-index: 9999;
            border: none;
            transition: background 0.2s;
        }
        #sc-chat-toggle:hover {
            background: #B0D5D9;
            color: #595959;
        }
        #sc-chat-widget {
            position: fixed;
            bottom: 80px;
            right: 30px;
            width: 340px;
            max-width: 95vw;
            background: #F2F2F2;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            display: none;
            flex-direction: column;
            z-index: 10000;
            overflow: hidden;
            border: 2px solid #6BBFBF;
            font-family: inherit;
        }
        #sc-chat-widget .sc-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px 10px 18px;
            background: #6BBFBF;
            border-radius: 16px 16px 0 0;
            border-bottom: 1px solid #B0D5D9;
        }
        #sc-chat-widget .sc-logo {
            height: 36px;
            width: 36px;
            border-radius: 8px;
            background: #fff;
            object-fit: contain;
        }
        #sc-chat-widget .sc-title {
            color: #fff;
            font-size: 1.25rem;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        #sc-chat-widget #sc-messages {
            padding: 20px 10px 10px 10px;
            height: 320px;
            overflow-y: auto;
            background: #C4EEF2;
            font-size: 1rem;
        }
        #sc-chat-widget .sc-input-area {
            display: flex;
            align-items: center;
            gap: 8px;
            border-top: 1px solid #B0D5D9;
            padding: 8px 10px 8px 10px;
            background: #F2F2F2;
        }
        #sc-chat-widget input[type="text"] {
            flex: 1;
            padding: 10px 14px;
            font-size: 1rem;
            border: 1px solid #B0D5D9;
            border-radius: 8px;
            outline: none;
            background: #fff;
            color: #595959;
            height: 40px;
            box-sizing: border-box;
        }
        #sc-chat-widget button#sc-send-btn {
            padding: 0 22px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background: #4dd0e1;
            color: #fff;
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        #sc-chat-widget button#sc-send-btn:hover {
            background: #0097a7;
            color: #fff;
        }
        #sc-chat-widget button#sc-send-btn:hover {
            background: #B0D5D9;
            color: #595959;
        }
        #sc-chat-widget .sc-message {
            margin-bottom: 10px;
            padding: 10px 14px;
            border-radius: 14px;
            max-width: 90%;
            word-break: break-word;
        }
        #sc-chat-widget .sc-message.user {
            background: #B0D5D9;
            align-self: flex-end;
            text-align: right;
            color: #595959;
        }
        #sc-chat-widget .sc-message.assistant {
            background: #fff;
            align-self: flex-start;
            text-align: left;
            color: #595959;
        }
    `;
    document.head.appendChild(style);
}

// 2. Crear botón flotante
let chatToggleButton = document.getElementById('sc-chat-toggle');
if (!chatToggleButton) {
    chatToggleButton = document.createElement('button');
    chatToggleButton.id = 'sc-chat-toggle';
    chatToggleButton.innerText = 'Chat';
    document.body.appendChild(chatToggleButton);
}

// 3. Crear widget de chat
let chatWidget = document.getElementById('sc-chat-widget');
if (!chatWidget) {
    chatWidget = document.createElement('div');
    chatWidget.id = 'sc-chat-widget';
    chatWidget.innerHTML = `
        <div class="sc-header">
            <img src=\"/src/img/favicon.png\" alt=\"Logo SocialiCar\" class=\"sc-logo\">
            <span class=\"sc-title\">SocialiCar Chatbot</span>
        </div>
        <div id=\"sc-messages\"></div>
        <div class=\"sc-input-area\"> 
            <input type=\"text\" id=\"sc-user-input\" placeholder=\"Escribe un mensaje...\" autocomplete=\"off\" />
            <button id=\"sc-send-btn\">Enviar</button>
        </div>
    `;
    document.body.appendChild(chatWidget);
}

// 4. Referencias
let userInput = chatWidget.querySelector('#sc-user-input');
let messagesContainer = chatWidget.querySelector('#sc-messages');
let sendButton = chatWidget.querySelector('#sc-send-btn');

// 5. Historial
let chatHistory = [
    { role: 'system', content: `Eres un asistente virtual conversacional y amable de SocialiCar, una plataforma de alquiler de coches entre particulares.\nResponde paso a paso y guía al usuario como lo haría un chatbot profesional como el de Amovens.\nSi te preguntan por coches, primero pregunta si son propietarios o arrendatarios.\nNo respondas a preguntas que no estén relacionadas con SocialiCar, si te preguntan por otras paginas que no sean socilicar respondeles de manera educada que no puedes ofrecer informacion con una pagina que no sea socialicar, En caso de que te pregunten si disponemos de una aplicacion movil, di que actualmente no disponemos de una pero que estamos trabajando en ella` }
];

// 6. Mostrar mensajes
function appendMessage(role, content) {
    let messageDiv = document.createElement('div');
    messageDiv.classList.add('sc-message', role);
    messageDiv.innerHTML = content;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// 7. Enviar mensaje real a OpenAI
async function sendMessageToOpenAI(message) {
    chatHistory.push({ role: 'user', content: message });
    appendMessage('user', message);
    userInput.value = '';
    if (!apiKey) {
        appendMessage('assistant', '<b>ERROR:</b> No se ha encontrado la API KEY en config.js o el archivo no se ha importado correctamente.<br>Revisa que <code>config.js</code> exista y tenga:<br><pre>export const config = {\n  API_KEY: "TU_API_KEY"\n};</pre>');
        return;
    }
    try {
        const response = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${apiKey}`,
            },
            body: JSON.stringify({
                model: 'gpt-3.5-turbo',
                messages: chatHistory
            })
        });
        const data = await response.json();
        let assistantMessage = data.choices && data.choices[0] && data.choices[0].message && data.choices[0].message.content ? data.choices[0].message.content : 'Lo siento, no he podido obtener respuesta.';
        chatHistory.push({ role: 'assistant', content: assistantMessage });

        // --- Lógica de redirección/botón ---
        // Palabras/frases clave para detectar intención de alquilar/buscar coche barato
        const redirKeywords = [
            'alquilar un coche',
            'buscar coche barato',
            'buscar uno baratito',
            'quiero alquilar',
            'quiero buscar coche',
            'coches baratos',
            'buscar coches baratos',
            'ver coches baratos',
            'quiero ver coches baratos',
            'quiero ver coches para alquilar',
            'quiero alquilar un coche',
            'quiero ver coches',
            'buscar coches para alquilar',
            'necesito alquilar un coche'
        ];
        const userMsgLower = message.toLowerCase();
        let shouldSuggest = redirKeywords.some(kw => userMsgLower.includes(kw));
        // También detecta si el propio mensaje del asistente invita a buscar coches baratos
        if (!shouldSuggest) {
            const assistantMsgLower = assistantMessage.toLowerCase();
            shouldSuggest = redirKeywords.some(kw => assistantMsgLower.includes(kw));
        }
        if (shouldSuggest) {
            // Opción 1: Mostrar botón/enlace en el chat
            const url = 'https://socialicar.wuaze.com/src/pages/rentacar/mostrar_coches';
            appendMessage('assistant', `<a href="${url}" target="_blank" style="display:inline-block;margin:10px 0;padding:10px 18px;background:#6BBFBF;color:#fff;border-radius:10px;text-decoration:none;font-weight:bold;">Ver coches baratos en SocialiCar</a>`);
            // Opción 2: Redirección automática (descomenta para activar)
            // window.open(url, '_blank'); // o window.location.href = url;
        }
        // --- Fin lógica redirección/botón ---

        appendMessage('assistant', assistantMessage);
    } catch (e) {
        appendMessage('assistant', 'Lo siento, ocurrió un error al contactar con OpenAI.');
    }
}

// 8. Eventos
sendButton.addEventListener('click', function() {
    let msg = userInput.value.trim();
    if (msg) sendMessageToOpenAI(msg);
});
userInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') sendButton.click();
});
chatToggleButton.addEventListener('click', function() {
    if (chatWidget.style.display === 'none' || chatWidget.style.display === '') {
        chatWidget.style.display = 'flex';
        if (!chatWidget.dataset.welcomeShown) {
            let welcomeMessage = '¡Hola! 👋 Soy el asistente virtual de SocialiCar. ¿Eres propietario de un coche o estás buscando alquilar uno?';
            appendMessage('assistant', welcomeMessage);
            chatHistory.push({ role: 'assistant', content: welcomeMessage });
            chatWidget.dataset.welcomeShown = 'true';
        }
    } else {
        chatWidget.style.display = 'none';
    }
});

// El botón y el chat siempre aparecen, aunque la clave no esté disponible
});


// Función para mostrar un mensaje en el chat
function appendMessage(role, content) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', role);
    messageDiv.innerHTML = `${content}`;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Función para enviar el mensaje al modelo de OpenAI o responder directamente si pregunta por coches baratos o suscripciones
async function sendMessageToOpenAI(message) {
    chatHistory.push({ role: 'user', content: message });

    const lowerMessage = message.toLowerCase();

    // Comprobar si la consulta es sobre suscripciones o planes
    const palabrasClaveSuscripcion = [
        'suscripción',
        'suscripciones',
        'plan de suscripción',
        'planes premium',
        'suscripción premium',
        'suscripción básica',
        'qué incluye la suscripción',
        'cómo funciona la suscripción',
        'plan',
        'planes',
        'tipos de planes',
        'qué tipos de planes',
        'qué planes',
        'que tipos de planes',
        'que planes',
        'planes de socialicar',
        'tipos de plan',
        'qué tipos de plan',
        'que tipos de plan'
    ];

    const coincideSuscripcion = palabrasClaveSuscripcion.some(frase => lowerMessage.includes(frase));

    // Comprobación adicional por si el usuario menciona 'plan' o 'planes' junto a 'socialicar'
    const mencionaPlanes = (lowerMessage.includes('plan') || lowerMessage.includes('planes')) && lowerMessage.includes('socialicar');

    if (coincideSuscripcion || mencionaPlanes) {
        const respuestaSuscripcion = `¡Claro! En SocialiCar tenemos dos tipos de planes de suscripción pensados para ti:<br><br>
🟢 <b>Suscripción Básica</b>: Disfruta de descuentos exclusivos y posiciona tu vehículo en las primeras posiciones una vez por semana.<br><br>
🟣 <b>Suscripción Premium</b>: Posiciona tus vehículos siempre en las primeras posiciones, accede a vehículos reservados solo para usuarios Premium, disfruta de reservas prioritarias y recibe ofertas y descuentos únicos.<br><br>
Puedes ver todos los detalles y elegir el plan que más te convenga aquí: <a href=\"https://socialicar.wuaze.com/src/pages/usuario/planes\" target=\"_blank\">Ver planes de suscripción</a> 🚗✨<br><br>
¿Te gustaría que te ayude a elegir el mejor plan para ti o tienes alguna otra duda? 😊`;
        appendMessage('assistant', respuestaSuscripcion);
        chatHistory.push({ role: 'assistant', content: respuestaSuscripcion });
        return;
    }

    // Respuesta específica para suscripción básica
    const palabrasClaveBasica = [
        'suscripción básica',
        'plan básico',
        'que incluye la suscripción básica',
        'que trae la suscripción básica',
        'beneficios suscripción básica',
        'ventajas suscripción básica',
        'que ofrece la suscripción básica',
        'que incluye el plan básico',
        'que trae el plan básico',
        'beneficios plan básico',
        'ventajas plan básico',
        'que ofrece el plan básico'
    ];
    const coincideBasica = palabrasClaveBasica.some(frase => lowerMessage.includes(frase));
    if (coincideBasica) {
        const respuestaBasica = `La <b>suscripción básica</b> de SocialiCar te permite:<br>- Disfrutar de descuentos exclusivos.<br>- Posicionar tu vehículo en las primeras posiciones una vez por semana.<br><br>¿Quieres saber más sobre cómo suscribirte o necesitas ayuda adicional? ¡Estoy aquí para ayudarte! 😊`;
        appendMessage('assistant', respuestaBasica);
        chatHistory.push({ role: 'assistant', content: respuestaBasica });
        return;
    }

    // Respuesta específica para suscripción premium
    const palabrasClavePremium = [
        'suscripción premium',
        'plan premium',
        'que incluye la suscripción premium',
        'que trae la suscripción premium',
        'beneficios suscripción premium',
        'ventajas suscripción premium',
        'que ofrece la suscripción premium',
        'que incluye el plan premium',
        'que trae el plan premium',
        'beneficios plan premium',
        'ventajas plan premium',
        'que ofrece el plan premium'
    ];
    const coincidePremium = palabrasClavePremium.some(frase => lowerMessage.includes(frase));
    if (coincidePremium) {
        const respuestaPremium = `La <b>suscripción premium</b> de SocialiCar te ofrece:<br>- Posicionar tus vehículos siempre en las primeras posiciones.<br>- Acceso a vehículos reservados solo para usuarios Premium.<br>- Reservas prioritarias.<br>- Ofertas y descuentos únicos.<br><br>¿Te gustaría más información sobre cómo obtener la suscripción premium? ¡Estoy aquí para ayudarte! 🚗✨`;
        appendMessage('assistant', respuestaPremium);
        chatHistory.push({ role: 'assistant', content: respuestaPremium });
        return;
    }

    // Comprobar si la consulta es sobre coches baratos
    const palabrasClaveCochesBaratos = [
        'coche barato',
        'coches baratos',
        'coche económico',
        'coche más barato',
        'alquiler barato',
        'rentar coche barato',
        'alquilar coche barato'
    ];

    const coincideCochesBaratos = palabrasClaveCochesBaratos.some(frase => lowerMessage.includes(frase));

    if (coincideCochesBaratos) {
        const respuesta = `¡Genial! En SocialiCar tenemos una variedad de coches disponibles para alquilar. Puedes ver todos los coches disponibles y aplicar filtros para encontrar lo que más te convenga en este enlace: <a href="https://socialicar.wuaze.com/src/pages/rentacar/mostrar_coches" target="_blank">Ver coches disponibles</a> 🚗💨`;
        appendMessage('assistant', respuesta);
        chatHistory.push({ role: 'assistant', content: respuesta });
        return;
    }

    // Responder sobre alquilar el coche del usuario
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
