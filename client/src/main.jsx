import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css'; // Si tienes estilos globales
import App from './App'; // El componente principal
import { BrowserRouter } from 'react-router-dom'; // Importamos BrowserRouter

const root = ReactDOM.createRoot(document.getElementById('root'));

// Renderizamos la aplicación envolviendo todo con BrowserRouter para manejar el enrutamiento
root.render(
  <BrowserRouter>
    <App />
  </BrowserRouter>
);

/* root.render(
  <BrowserRouter>
    <App />
    <Hero />
    <Sponsors />
    <RentACar />
    <FAQ />
    <Blog />
    <Footer />
  </BrowserRouter>
); */