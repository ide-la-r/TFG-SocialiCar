<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="src/img/favicon.png" />
    <title>SocialiCar - Comparte tu coche</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <?php include_once 'src/components/navbar.php'; ?>

    <!-- BANNER (Hero) -->
    <div>
        <h1>Encuentra tu vehiculo ideal</h1>
        <p>Alquila vehículos de forma segura</p>
    </div>

    <!-- BARRA DE BUSQUEDA -->
    <form class="w-75 mx-auto">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Busca un vehículo...">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    <br><br>

    <!-- MENU DE FILTROS DEL COCHE -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">

                <!-- MARCA -->
                <div>
                    <label class="form-label">Marca:</label>
                    <select class="form-select">
                        <option selected>- - Selecciona un tipo - -</option>
                        <option value="1">Alfa Romeo</option>
                        <option value="2">Volkswagen</option>
                        <option value="3">BMW</option>
                        <option value="4">Mercedes</option>
                        <option value="5">Nissan</option>
                        <!-- API coches para marcas -->
                    </select>
                </div><br>

                <!-- MODELO -->
                <div>
                    <label class="form-label">Modelo:</label>
                    <select class="form-select">
                        <option selected>- - Selecciona un tipo - -</option>
                        <option value="1">Modelo</option>
                        <!-- API coches para modelos QUE CAMBIARAN SEGUN LA MARCA-->
                    </select>
                </div><br>

                <!-- CIUDAD -->
                <div>
                    <label for="ciudad" class="form-label">Ubicación:</label>
                    <select id="ciudad" class="form-select">
                        <option selected>- - Selecciona una ciudad - -</option>
                        <option value="1">Málaga</option>
                        <option value="2">Granada</option>
                        <option value="3">Madrid</option>
                        <option value="4">Valencia</option>
                        <option value="5">Barcelona</option>
                    </select>
                </div><br>

                <!-- TIPO -->
                <div>
                    <label class="form-label">Tipo de Coche:</label>
                    <select class="form-select">
                        <option selected>- - Selecciona un tipo - -</option>
                        <option value="1">Berlina</option>
                        <option value="2">Coupé</option>
                        <option value="3">Monovolumen</option>
                        <option value="4">SUV</option>
                        <option value="5">Familiar</option>
                        <option value="6">Furgoneta</option>
                        <option value="7">Utilitario</option>
                        <option value="8">Autocaravana</option>
                    </select>
                </div><br>

                <!-- COMBUSTIBLE -->
                <div>
                    <label class="form-label">Combustible:</label>
                    <select class="form-select">
                        <option selected>- - Selecciona un tipo - -</option>
                        <option value="Diésel">Diésel</option>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Eléctrico">Eléctrico</option>
                        <option value="Híbrido">Híbrido</option>
                    </select>
                </div><br>

                <!-- PRECIO -->
                <div>
                    <label class="form-label">Precio Diario (€):</label>

                    <input type="range" class="form-range" id="precio" min="0" max="500" step="10">

                    <div class="d-flex justify-content-between"> <!-- separación -->
                        <span>€0</span>
                        <span>€500</span>
                    </div>
                </div><br>


                <!-- FECHAS (DISPONIBILIDAD) HABRA QUE EL FIN NO SEA ANTERIOR AL INICIO-->
                <div>
                    <label class="form-label">Disponibilidad</label>
                    <div class="d-flex gap-2">
                        <div class="flex-fill">
                            <label class="form-label">Inicio</label>
                            <input type="date" class="form-control" id="FechaInicio" />
                        </div>
                        <div class="flex-fill">
                            <label class="form-label">Fin</label>
                            <input type="date" class="form-control" id="FechaFin" />
                        </div>
                    </div>
                </div><br>

                <!-- OTROS FILTROS -->
                <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="mascotas">
                        <label class="form-check-label" for="mascotas">Acepta mascotas</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="fumador">
                        <label class="form-check-label" for="fumador">Fumador</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="movilidad">
                        <label class="form-check-label" for="movilidad">Movilidad reducida</label>
                    </div>
                </div>

                <!-- EQUIPAMIENTO -->
                <div>
                    <label class="form-label">Otros filtros</label>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="movilidad">
                        <label class="form-check-label" for="bluetooh">Bluetooh</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="movilidad">
                        <label class="form-check-label" for="wifi">WiFi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="movilidad">
                        <label class="form-check-label" for="camara_reversa">Cámara reversa</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="movilidad">
                        <label class="form-check-label" for="control_crucero">Control crucero</label>
                    </div>
                </div>



                <!-- APLICAR FILTROS -->
                <div>
                    <button class="btn btn-primary" type="button">Aplicar Filtros</button>
                </div>
            </div>



        </div>
    </div>


    <!-- Footer -->
    <?php include_once 'src/components/footer.php'; ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.js"></script>
</body>

</html>