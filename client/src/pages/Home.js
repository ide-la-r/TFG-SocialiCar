import React, { useEffect, useState } from 'react';
import axios from 'axios';

function Home() {
  const [listofcars, setListofCars] = useState([]);
  const [searchQuery, setSearchQuery] = useState('');

  // Cargar los coches desde la API
  useEffect(() => {
    axios.get("http://localhost:3001/cars")
      .then((response) => {
        setListofCars(response.data);
      })
      .catch((error) => {
        console.error("Hubo un error al cargar los coches: ", error);
      });
  }, []);

  // Filtrar los coches según el input de búsqueda
  const filteredCars = listofcars.filter(car =>
    car.marca.toLowerCase().includes(searchQuery.toLowerCase()) ||
    car.modelo.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <div>
      <div className="container-fluid">
        <h1>Encuentra tu coche ideal</h1>
        <form className="d-flex input-group w-auto">
          <input
            type="search"
            className="form-control rounded"
            placeholder="¿Qué coche buscas?"
            aria-label="¿Qué coche buscas?"
            aria-describedby="search-addon"
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)} // Actualizar el estado del input
          />
          <span className="input-group-text border-0" id="search-addon">
            <i className="fas fa-search"></i>
          </span>
        </form>
      </div>

      {/* Mostrar los coches filtrados */}
      {filteredCars.length > 0 ? (
        filteredCars.map((value) => (
          <div className="Usuarios" key={value.id}> {/* Usar 'id' o cualquier campo único */}
            <div className="nombre">
              <p>{value.marca}</p>
            </div>
            <div className="apellidos">
              <p>{value.modelo}</p>
            </div>
            <div className="dni">
              <p>{value.combustible}</p>
            </div>
          </div>
        ))
      ) : (
        <p>No se encontraron coches para tu búsqueda.</p>
      )}
    </div>
  );
}

export default Home;
