import './App.css'; // Estilos personalizados
import 'bootstrap/dist/css/bootstrap.min.css'; // Bootstrap
import RegistroUsuario from './components/RegistroUsuario'; // Importamos el componente de registro
import { Routes, Route } from 'react-router-dom';

function App() {
  return (
    <div className="container mt-5">
      <h1>Bienvenido a SocialiCar</h1>
      <Routes>
        <Route path="/" element={<h2>Bienvenido</h2>} />
        <Route path="/registro" element={<RegistroUsuario />} />
        <Route path="*" element={<h2>Ruta no encontrada</h2>} />
      </Routes>
    </div>
  );
}

export default App;