<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    session_start();
    require(__DIR__ . "/../../config/conexion.php");
    require(__DIR__ . "/../../config/depurar.php");
    ?>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <form action="#" method="post">
        <div class="container card text-center card_registro" style="width: 40rem;">
            <h1 class="register">Añadir coche</h1>






            <form action="" class="form-floating">
                <div class="row justify-content-center">
                    <div class="mb-3 col-4">
                        <input class="form-control" type="text" placeholder="Matricula*" name="matricula">
                    </div>
                    <div class="mb-3 col-4">
                        <input class="form-control" type="text" placeholder="Marca*" name="marca">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" placeholder="Modelo*" name="modelo">
                    </div>

                    <div class="mb-3 col-8">
                        <input id="contrasena" class="form-control" type="month" placeholder="Año de matriculación*" name="anno_matriculacion">
                    </div>

                    <div class="mb-3 col-8">
                        <input id="validarContrasena" class="form-control" type="number" placeholder="Kilómetros*" name="kilometros">
                    </div>

                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" placeholder="Ubicación*" name="ubicacion">
                    </div>

                    <div class="mb-3 col-8">
                        <input class="form-control" type="file" placeholder="Imagen*" name="imagen">
                    </div>

                    <div class="mb-3 col-8">
                        <Select id="tipoIdentificacion" class="form-select">
                            <option disabled selected hidden>Tipo de combustible*</option>
                            <option value="gasolina">Gasolina</option>
                            <option value="diesel">Diesel</option>
                            <option value="hibrido">Hibrido</option>
                            <option value="electrico">Eléctrico</option>
                            <option value="glp">GLP</option>
                            <option value="gnc">GNC</option>
                        </Select>
                    </div>



                    <div class="mb-3 col-8">
                        <Select id="tipoIdentificacion" class="form-select">
                            <option disabled selected hidden>Transmisión*</option>
                            <option value="manual">Manual</option>
                            <option value="automatico">Automático</option>
                        </Select>
                    </div>


                    <div class="mb-3 col-8">
                        <Select id="tipoIdentificacion" class="form-select">
                            <option disabled selected hidden>Tipo de aparcamiento*</option>
                            <option value="calle">Calle </option>
                            <option value="garaje">Garaje</option>
                            <option value="parking">Parking</option>
                        </Select>
                    </div>

                    <!-- INICIO SECCION DE IMAGENES -->
                    <div class="mb-4">
                        <label class="form-label fw-bold fs-4 mb-2 text-start" style="display:block">Fotos</label>
                        <div class="border rounded-3 p-3 mb-3 bg-white" style="border-style: dashed; border-width: 2px;">
                            <div class="d-flex align-items-center mb-1">
                                <label for="fotosCoche" class="b    tn btn-outline-success fw-bold me-3 mb-0" style="border-radius: 2rem; cursor:pointer;">Subir fotos</label>
                                <input type="file" id="fotosCoche" name="fotosCoche[]" accept="image/jpeg, image/png, image/webp" multiple style="display:none;" aria-label="Subir fotos del coche">
                                <div>
                                    <span class="fw-semibold">Arrastra tus fotos aquí</span><br>
                                    <span class="text-muted" style="font-size: 0.95em;">Formatos aceptados: JPEG, PNG y WebP. Tamaño límite: 10 MB por archivo.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-5 g-3 justify-content-center">
                            <!-- CAJAS IMAGENES DE LOS COCHES -->
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIN SECCION DE IMAGENES -->

                    <div class="mb-3 col-8">
                        <input class="form-control" placeholder="" id="identificacion" type="text" hidden>
                    </div>
                </div>
                <!--BOTON VENTANA MODAL CON BOOTSTRAP-->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                    Extras
                </button>
            </form>
            <!--BOTON PARA ENVIAR EL FORMULARIO -->
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                Confirmar
            </button>
        </div>
        </div>


        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">Seleciona los extras</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group checkbox-group row">
                            <label class="col-6"><input type="checkbox" name="aire_acondicionado"> Aire acondicionado</label>
                            <label class="col-6"><input type="checkbox" name="gps"> GPS</label>
                            <label class="col-6"><input type="checkbox" name="wifi"> Wifi</label>
                            <label class="col-6"><input type="checkbox" name="sensores_aparcamiento"> Sensores de aparcamiento</label>
                            <label class="col-6"><input type="checkbox" name="camara_reversa"> Cámara de reversa</label>
                            <label class="col-6"><input type="checkbox" name="control_crucero"> Control de crucero</label>
                            <label class="col-6"><input type="checkbox" name="asientos_calefactables"> Asientos calefactables</label>
                            <label class="col-6"><input type="checkbox" name="mascota"> Mascota permitida</label>
                            <label class="col-6"><input type="checkbox" name="fumar"> Se permite fumar</label>
                            <label class="col-6"><input type="checkbox" name="accesibilidad"> Adaptado para personas con movilidad reducida</label>
                            <label class="col-6"><input type="checkbox" name="bola_remolque">Bola de remolque</label>
                            <label class="col-6"><input type="checkbox" name="aire_acondicionado">Aire acondicionado</label>
                            <label class="col-6"><input type="checkbox" name="fijaciones_isofix">Fijaciones isofix</label>
                            <label class="col-6"><input type="checkbox" name="android_carplay">Android carplay</label>
                            <label class="col-6"><input type="checkbox" name="apple_carplay">Apple carplay</label>
                            <label class="col-6"><input type="checkbox" name="baca">Baca</label>
                            <label class="col-6"><input type="checkbox" name="portabicicletas">Portabicicletas</label>
                            <label class="col-6"><input type="checkbox" name="portaequipajes">Portaequipajes</label>
                            <label class="col-6"><input type="checkbox" name="portaesquis">Portaesquis</label>

                        </div>
                    </div>


                    <!--BOTON CERRAR DE LA VENTANA MODAL-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>



    </form>
    <?php include_once '../../components/footer.php'; ?>

</body>

</html>