import './App.css';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import Home from './pages/Home';
import AlquilarCoche from './pages/AlquilarCoche';

function App() {
  return (
    <div className="App">
      <Router>
        <Link to="/">Home</Link>
        <Link to="/rentacar">Alquilar Coche</Link>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/rentacar" element={<AlquilarCoche />} />
        </Routes>
      </Router>
    </div>
  );
}

export default App;
 