import React from 'react'
import axios from 'axios';
import { useEffect, useState } from 'react';

function Home() {

    const [listofusers, setListofUsers] = useState([]);
    useEffect(() => {
        axios.get("http://localhost:3001/users/register").then((response) => {
        setListofUsers(response.data);
        })
    }, []);

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
            />
            <span className="input-group-text border-0" id="search-addon">
              <i className="fas fa-search"></i>
            </span>
          </form>
        </div>
        {listofusers.map((value, key) => {
        return (
          <div className='Usuarios'> 
            <div className='nombre'> {value.nombre} </div>
            <div className='apellidos'> {value.apellido} </div> 
            <div className='dni'> {value.dni} </div> 
          </div>
        )
      })}
    </div>
  )
}

export default Home