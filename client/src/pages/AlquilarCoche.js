import React, { useState, useEffect } from 'react';
import { Formik, Form, Field, ErrorMessage } from 'formik';
import * as Yup from "yup";
import axios from 'axios';

function AlquilarCoche() {
  const [marcas, setMarcas] = useState([]);
  const [modelos, setModelos] = useState([]);

  const initialValues = {
    id_usuario: '',
    matricula: '',
    seguro: false,
    marca: '',
    modelo: '',
    anno_matriculacion: '',
    kilometros: '',
    combustible: '',
    transmision: '',
    ubicacion: '',
    tipo_aparcamiento: '',
    mascota: false,
    fumar: false,
    ruta_img_coche: ''
  };

  useEffect(() => {
    axios.get("https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/car?format=json")
      .then(res => setMarcas(res.data.Results));
  }, []);

  const handleMarcaChange = (e, setFieldValue) => {
    const makeId = e.target.selectedOptions[0].getAttribute("data-id");
    setFieldValue("marca", e.target.value);
    setFieldValue("modelo", ""); // Reinicia modelo seleccionado
    if (makeId) {
      axios.get(`https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMakeId/${makeId}?format=json`)
        .then(res => setModelos(res.data.Results));
    }
  };

  const onSubmit = (data) => {
    const formData = new FormData();
    for (let key in data) {
      formData.append(key, data[key]);
    }
    axios.post("http://localhost:3001/cars/rentacar", formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    }).then(() => {
      console.log("Coche enviado correctamente");
    }).catch(err => {
      console.error("Error al enviar:", err);
    });
  };

  const validationSchema = Yup.object().shape({
    id_usuario: Yup.string().required("* Campo obligatorio"),
    matricula: Yup.string().required("* Campo obligatorio"),
    marca: Yup.string().required("* Campo obligatorio"),
    modelo: Yup.string().required("* Campo obligatorio"),
    anno_matriculacion: Yup.date().required("* Campo obligatorio"),
    kilometros: Yup.number().required("* Campo obligatorio").positive("Debe ser positivo"),
    combustible: Yup.string().required("* Campo obligatorio"),
    transmision: Yup.string().required("* Campo obligatorio"),
    ubicacion: Yup.string().required("* Campo obligatorio"),
    tipo_aparcamiento: Yup.string().required("* Campo obligatorio"),
    ruta_img_coche: Yup.mixed().required("* Campo obligatorio")
  });

  return (
    <div className='addCoche'>
      <h2>Formulario de Alquiler de Coche</h2>
      <Formik
        initialValues={initialValues}
        onSubmit={onSubmit}
        validationSchema={validationSchema}
      >
        {({ setFieldValue }) => (
          <Form>
            <label>Usuario (ID):</label>
            <ErrorMessage name="id_usuario" component="span" />
            <Field name="id_usuario" placeholder="ID del usuario" />

            <label>Matrícula:</label>
            <ErrorMessage name="matricula" component="span" />
            <Field name="matricula" placeholder="1234ABC" />

            <label>¿Tiene seguro?</label>
            <Field type="checkbox" name="seguro" />

            <label>Marca:</label>
            <ErrorMessage name="marca" component="span" />
            <Field as="select" name="marca" onChange={(e) => handleMarcaChange(e, setFieldValue)}>
              <option value="" disabled hidden>Selecciona una marca</option>
              {marcas.map(m => (
                <option key={m.MakeId} value={m.MakeName} data-id={m.MakeId}>{m.MakeName}</option>
              ))}
            </Field>

            <label>Modelo:</label>
            <ErrorMessage name="modelo" component="span" />
            <Field as="select" name="modelo">
              <option value="" disabled hidden>Selecciona un modelo</option>
              {modelos.map(m => (
                <option key={m.Model_ID} value={m.Model_Name}>{m.Model_Name}</option>
              ))}
            </Field>

            <label>Año de matriculación:</label>
            <ErrorMessage name="anno_matriculacion" component="span" />
            <Field type="date" name="anno_matriculacion" />

            <label>Kilómetros:</label>
            <ErrorMessage name="kilometros" component="span" />
            <Field name="kilometros" placeholder="30500" />

            <label>Combustible:</label>
            <ErrorMessage name="combustible" component="span" />
            <Field as="select" name="combustible">
              <option value="" disabled hidden>Selecciona tipo de combustible</option>
              <option value="Gasolina">Gasolina</option>
              <option value="Diésel">Diésel</option>
              <option value="Eléctrico">Eléctrico</option>
              <option value="Híbrido">Híbrido</option>
              <option value="GLP">GLP</option>
              <option value="GNC">GNC</option>
            </Field>

            <label>Transmisión:</label>
            <ErrorMessage name="transmision" component="span" />
            <Field as="select" name="transmision">
              <option value="" disabled hidden>Selecciona tipo de transmisión</option>
              <option value="Manual">Manual</option>
              <option value="Automática">Automática</option>
            </Field>

            <label>Ubicación:</label>
            <ErrorMessage name="ubicacion" component="span" />
            <Field name="ubicacion" placeholder="Málaga" />

            <label>Tipo de aparcamiento:</label>
            <ErrorMessage name="tipo_aparcamiento" component="span" />
            <Field as="select" name="tipo_aparcamiento">
              <option value="" disabled hidden>Selecciona tipo de aparcamiento</option>
              <option value="Calle">Calle</option>
              <option value="Garaje">Garaje</option>
              <option value="Parking público">Parking público</option>
            </Field>

            <label>¿Se permiten mascotas?</label>
            <Field type="checkbox" name="mascota" />

            <label>¿Se permite fumar?</label>
            <Field type="checkbox" name="fumar" />

            <label>Imagen del coche:</label>
            <ErrorMessage name="ruta_img_coche" component="span" />
            <input
              type="file"
              name="ruta_img_coche"
              accept="image/*"
              onChange={(event) => {
                setFieldValue("ruta_img_coche", event.currentTarget.files[0]);
              }}
            />

            <button type="submit">¡Alquilar!</button>
          </Form>
        )}
      </Formik>
    </div>
  );
}

export default AlquilarCoche;