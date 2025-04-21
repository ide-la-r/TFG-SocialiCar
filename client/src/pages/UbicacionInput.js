import React, { useState, useRef, useEffect } from 'react';
import { Field, ErrorMessage, useFormikContext } from 'formik';

const UbicacionInput = () => {
  const [sugerencias, setSugerencias] = useState([]);
  const [mostrarSugerencias, setMostrarSugerencias] = useState(false);
  const [valorInput, setValorInput] = useState('');
  const timeoutRef = useRef(null);
  const { setFieldValue } = useFormikContext();

  const handleChange = (e) => {
    const value = e.target.value;
    setValorInput(value);
    setFieldValue('ubicacion', value);

    if (timeoutRef.current) clearTimeout(timeoutRef.current);

    timeoutRef.current = setTimeout(() => {
      if (value.length >= 3) {
        fetchSugerencias(value);
      } else {
        setSugerencias([]);
      }
    }, 500);
  };

  const fetchSugerencias = async (valor) => {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&countrycodes=es&q=${valor}`);
        const data = await response.json();
        setSugerencias(data);
        setMostrarSugerencias(true);
    } catch (err) {
      console.error('Error al buscar direcciones', err);
    }
  };

  const seleccionarSugerencia = (direccion) => {
    setFieldValue('ubicacion', direccion.display_name);
    setValorInput(direccion.display_name);
    setSugerencias([]);
    setMostrarSugerencias(false);
  };


  useEffect(() => {
    return () => clearTimeout(timeoutRef.current);
  }, []);

  return (
    <div className="col-md-8 position-relative">
      <div className="form-floating">
        <Field
          className="form-control"
          name="ubicacion"
          placeholder="Málaga"
          value={valorInput}
          onChange={handleChange}
          autoComplete="off"
        />
        <label className="form-label">
          Ubicación <ErrorMessage className='subirError' name="ubicacion" component="span" />
        </label>
      </div>

      {mostrarSugerencias && sugerencias.length > 0 && (
        <ul className="list-group position-absolute w-100" style={{ zIndex: 10 }}>
          {sugerencias.slice(0, 5).map((sug, idx) => (
            <li
              key={idx}
              className="list-group-item list-group-item-action"
              onClick={() => seleccionarSugerencia(sug)}
              style={{ cursor: 'pointer' }}
            >
              {sug.display_name}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default UbicacionInput;
