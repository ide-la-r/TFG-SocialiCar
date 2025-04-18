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