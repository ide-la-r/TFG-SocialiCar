import React, { useState, useEffect } from 'react';
import { Formik, Form, Field, ErrorMessage } from 'formik';
import * as Yup from "yup";
import axios from 'axios';
import UbicacionInput from './UbicacionInput';


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
    ruta_img_coche: '',
    movilidadreducia: false,
    aireacondicionado: false,
    gps: false,
    wifi: false,
    sensoresaparcamiento: false,
    camaradereversa: false,
    controldecrucero: false,
    asientoscalefactables: false
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

  const onSubmit = (data, { resetForm }) => {
    const formData = new FormData();
  
    const fields = [
      'id_usuario', 'matricula', 'seguro', 'marca', 'modelo', 'anno_matriculacion',
      'kilometros', 'combustible', 'transmision', 'ubicacion', 'tipo_aparcamiento',
      'mascota', 'fumar', 'ruta_img_coche', 'movilidadreducia', 'aireacondicionado',
      'gps', 'wifi', 'sensoresaparcamiento', 'camaradereversa', 'controldecrucero',
      'asientoscalefactables'
    ];
  
    fields.forEach(key => {
      if (key === 'ruta_img_coche' && data[key]) {
        for (let file of data[key]) {
          formData.append(key, file);
        }
      } else {
        formData.append(key, data[key]);
      }
    });
  
    axios.post("http://localhost:3001/cars/rentacar", formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    }).then(() => {
      resetForm(); // Resetea el formulario
      alert("Coche registrado correctamente!");
    }).catch(err => {
      console.error("Error al enviar:", err);
      alert("Hubo un error al registrar el coche. Inténtalo de nuevo.");
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
    ruta_img_coche: Yup.array().min(1, "* Debe subir al menos una imagen").of(Yup.mixed().test("fileType", "Debe ser una imagen", (value) => value && value.type.startsWith("image/")))
  });

  return (
    <div className='addCoche'>
      <h1>Formulario de Alquiler de Coche</h1>
      <Formik
        initialValues={initialValues}
        onSubmit={onSubmit}
        validationSchema={validationSchema}
      >
        {({ setFieldValue }) => (
          <Form className='row g-3'>

            <div className='col-md-6 form-floating'>
              <Field className='form-control' name="id_usuario" placeholder="ID del usuario" />
              <label className='form-label'>Usuario (ID) <ErrorMessage className='subirError' name="id_usuario" component="span" /></label>
            </div>

            <div className='col-md-6 form-floating'>
              <Field className='form-control' name="matricula" placeholder="1234ABC" />
              <label className='form-label'>Matrícula <ErrorMessage className='subirError' name="matricula" component="span" /></label>
            </div>

            <div className='col-md-6 form-floating'>
              <Field className='form-select' as="select" name="marca" onChange={(e) => handleMarcaChange(e, setFieldValue)}>
                <option value="" disabled hidden>Selecciona una marca</option>
                {marcas.map(m => (
                  <option key={m.MakeId} value={m.MakeName} data-id={m.MakeId}>{m.MakeName}</option>
                ))}
              </Field>
              <label className='form-label'>Marca <ErrorMessage className='subirError' name="marca" component="span" /></label>
            </div>

            <div className='col-md-6 form-floating'>
              <Field className='form-select' as="select" name="modelo">
                <option value="" disabled hidden>Selecciona un modelo</option>
                {modelos.map(m => (
                  <option key={m.Model_ID} value={m.Model_Name}>{m.Model_Name}</option>
                ))}
              </Field>
              <label className='form-label'>Modelo <ErrorMessage className='subirError' name="modelo" component="span" /></label>
            </div>

            <div className='col-md-6 form-floating'>
              <Field className='form-control' type="month" name="anno_matriculacion" />
              <label className='form-label'>Fecha de matriculación <ErrorMessage className='subirError' name="anno_matriculacion" component="span" /></label>
            </div>

            <div className='col-md-6 form-floating'>
              <Field className='form-control' name="kilometros" placeholder="30500" />
              <label className='form-label'>Kilómetros <ErrorMessage className='subirError' name="kilometros" component="span" /></label>
            </div>

            <div className='col-md-6 form-floating'>
              <Field className='form-select' as="select" name="combustible">
                <option value="" disabled hidden>Selecciona tipo de combustible</option>
                <option value="Gasolina">Gasolina</option>
                <option value="Diésel">Diésel</option>
                <option value="Eléctrico">Eléctrico</option>
                <option value="Híbrido">Híbrido</option>
                <option value="GLP">GLP</option>
                <option value="GNC">GNC</option>
              </Field>
              <label className='form-label'>Combustible <ErrorMessage className='subirError' name="combustible" component="span" /></label>
            </div>

            <div className='col-md-6 form-floating'>
              <Field className='form-select' as="select" name="transmision">
                <option value="" disabled hidden>Selecciona tipo de transmisión</option>
                <option value="Manual">Manual</option>
                <option value="Automática">Automática</option>
              </Field>
              <label className='form-label'>Transmisión <ErrorMessage className='subirError' name="transmision" component="span" /></label>
            </div>

            <UbicacionInput />

            <div className="col-md-4 form-floating">
              <Field className="form-select" as="select" name="tipo_aparcamiento">
                <option value="" disabled hidden>Selecciona tipo de aparcamiento</option>
                <option value="Calle">Calle</option>
                <option value="Garaje">Garaje</option>
                <option value="Parking público">Parking público</option>
              </Field>
              <label className="form-label">Tipo de aparcamiento <ErrorMessage className='subirError' name="tipo_aparcamiento" component="span" /></label>
            </div>

            <div className="card mt-3">
              <div className="card-header">
                <h4 className="mb-0">Servicios del vehículo</h4>
              </div>
              <div className="card-body">
                <div className="row">
                  <div className="col-md-6">
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="seguro" name="seguro" />
                      <label className="form-check-label" htmlFor="seguro">¿Tiene seguro?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="mascota" name="mascota" />
                      <label className="form-check-label" htmlFor="mascota">¿Se permiten mascotas?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="fumar" name="fumar" />
                      <label className="form-check-label" htmlFor="fumar">¿Se permite fumar?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="movilidadreducia" name="movilidadreducia" />
                      <label className="form-check-label" htmlFor="movilidadreducia">¿Adaptado a movilidad reducida?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="aireacondicionado" name="aireacondicionado" />
                      <label className="form-check-label" htmlFor="aireacondicionado">¿Tiene aire acondicionado?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="gps" name="gps" />
                      <label className="form-check-label" htmlFor="gps">¿Tiene GPS?</label>
                    </div>
                  </div>

                  <div className="col-md-6">
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="wifi" name="wifi" />
                      <label className="form-check-label" htmlFor="wifi">¿Wi-Fi o Bluetooth?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="sensoresaparcamiento" name="sensoresaparcamiento" />
                      <label className="form-check-label" htmlFor="sensoresaparcamiento">¿Sensores de aparcamiento?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="camaradereversa" name="camaradereversa" />
                      <label className="form-check-label" htmlFor="camaradereversa">¿Cámara trasera?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="controldecrucero" name="controldecrucero" />
                      <label className="form-check-label" htmlFor="controldecrucero">¿Control de crucero?</label>
                    </div>
                    <div className="form-check form-switch mb-3">
                      <Field className="form-check-input" type="checkbox" role='switch' id="asientoscalefactables" name="asientoscalefactables" />
                      <label className="form-check-label" htmlFor="asientoscalefactables">¿Asientos calefactables?</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="form-group mt-3">
              <label htmlFor="ruta_img_coche">Imágenes del coche</label>
              <input
                className="form-control"
                type="file"
                name="ruta_img_coche"
                multiple
                accept="image/*" // Aceptar solo imágenes
                onChange={(event) => {
                  const files = event.target.files;
                  const validFiles = Array.from(files).filter(file => file.type.startsWith('image/'));
                  if (validFiles.length > 0) {
                    setFieldValue("ruta_img_coche", validFiles); // Pasar los archivos válidos a Formik
                  } else {
                    alert('Por favor, seleccione solo imágenes.');
                  }
                }}
              />
              <ErrorMessage className='subirError' name="ruta_img_coche" component="span" />
            </div>

            <button type="submit">¡Alquilar!</button>

          </Form>
        )}
      </Formik>
    </div>
  );
}

export default AlquilarCoche;