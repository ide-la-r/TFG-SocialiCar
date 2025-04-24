<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
        require(__DIR__ . '/../../config/bootstrap.php');
        require(__DIR__ . "/../../../src/config/conexion.php");

        /* if (!isset($_SESSION["usuario"])) {
            header("Location: " . BASE_URL . "src/pages/usuario/iniciar_sesion.php");
            exit;
        } */
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
                        <input id="contrasena" class="form-control" type="date" placeholder="Año de matriculación*" name="anno_matriculacion">
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
                            <option value="dni">Gasolina</option>
                            <option value="nie">Diesel</option>
                            <option value="nif">Hibrido</option>
                            <option value="nif">Eléctrico</option>
                            <option value="nif">GLP</option>
                            <option value="nif">GNC</option>
                        </Select>
                    </div>



                    <div class="mb-3 col-8">
                        <Select id="tipoIdentificacion" class="form-select">
                            <option disabled selected hidden>Transmisión*</option>
                            <option value="dni">Manual</option>
                            <option value="nie">Automática</option>
                        </Select>
                    </div>


                    <div class="mb-3 col-8">
                        <Select id="tipoIdentificacion" class="form-select">
                            <option disabled selected hidden>Tipo de aparcamiento*</option>
                            <option value="dni">Calle </option>
                            <option value="nie">Garaje</option>
                            <option value="nie">Parking</option>
                        </Select>
                    </div>



                    <div class="mb-3 col-8">
                        <input class="form-control" placeholder="" id="identificacion" type="text" hidden>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                Extras
            </button>
            </form>
            <!--BOTON VENTANA MODAL CON BOOTSTRAP-->
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
                            <label class="col-6"><input type="checkbox" name="seguro">Seguro</label>

                        </div>
                    </div>


                    <!--BOTON CERRAR DE LA VENTANA MODAL-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para enviar el formulario -->

    </form>
    <?php include_once '../../components/footer.php'; ?>

</body>

</html>