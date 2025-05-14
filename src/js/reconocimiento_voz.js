let element = document.getElementById("text");

const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();

recognition.lang = "es-ES";
recognition.continuous = true;

document.onclick = () => {
    recognition.start();
};

recognition.onresult = (event) => {
    let resultadoTexto = "";
    for (const result of event.results) {
        resultadoTexto += result[0].transcript;
    }
    element.innerHTML = resultadoTexto;
};

recognition.onerror = (event) => {
    console.error("Error de reconocimiento:", event.error);
};

recognition.onend = () => {
    console.log("Reconocimiento de voz finalizado.");
};
