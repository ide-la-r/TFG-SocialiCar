import './App.css';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import Home from './pages/Home';
import AlquilarCoche from './pages/AlquilarCoche';
import nav from './img/nav.png';
import perfil from './img/perfil.png';

function App() {
  return (
    <div className="App">
        <Router>
          <nav className="navbar navbar-expand-lg bg-body-tertiary">
            <div className="container-fluid">
              {/* Botón para móviles */}
              <button
                className="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
                style={{
                  border: 'none',
                  backgroundColor: 'transparent',
                }}
              >
                <i className="fas fa-bars" style={{ color: '#343434', fontSize: '1.5rem' }}></i>
              </button>

              {/* Logo */}
              <Link className="navbar-brand mt-2 mt-lg-0" to="/">
                <img
                  src={nav}
                  height="30"
                  alt="SocialiCar Logo"
                  loading="lazy"
                />
              </Link>

              {/* Contenido colapsable */}
              <div className="collapse navbar-collapse" id="navbarSupportedContent">
                <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                  <li className="nav-item">
                    <Link className="nav-link" to="/">Inicio</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/rentacar">Alquilar Coche</Link>
                  </li>
                </ul>
              </div>

              {/* Elementos a la derecha */}
              <div className="d-flex align-items-center">
                
                {/* Notificaciones */}
                <div className="dropdown">
                  <Link
                    className="text-reset me-3"
                    to="/"
                    role="button"
                    aria-expanded="false"
                  >
                    <i class="fa-regular fa-comment-dots fa-flip-horizontal"></i>
                    <span className="badge rounded-pill bg-danger">1</span>
                  </Link>
                </div>

                {/* Avatar usuario */}
                <div className="dropdown">
                  <Link
                    className="dropdown-toggle d-flex align-items-center hidden-arrow"
                    to="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <img
                      src={perfil}
                      className="rounded-circle"
                      height="30"
                      alt="Avatar"
                      loading="lazy"
                    />
                  </Link>
                  <ul className="dropdown-menu dropdown-menu-end">
                    <li>
                      <Link className="dropdown-item" to="#">
                        <i class="fa-regular fa-circle-user me-2"></i>
                        Mi perfil
                      </Link>
                    </li>
                    <li>
                      <Link className="dropdown-item" to="#">
                        <i class="fa-regular fa-circle-question me-2"></i>
                        Configuración
                      </Link>
                    </li>
                    <li>
                      <Link className="dropdown-item" to="#">
                          <i className="fa-regular fa-circle-xmark me-2"></i>
                          Cerrar sesión
                      </Link>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </nav>
      <div className="container">
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/rentacar" element={<AlquilarCoche />} />
          </Routes>
      </div>
        </Router>
    </div>
  );
}

export default App;
 