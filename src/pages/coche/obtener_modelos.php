<?php
session_start();
// Redirigir si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../");
    exit();
}


if (isset($_GET['marca'])) {
    $marcaSeleccionada = $_GET['marca'];

    // API para obtener todas las marcas
    $apiUrlMarcas = "https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/car?format=json";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrlMarcas);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    $datos = json_decode($respuesta, true);
    $marcas = $datos['Results'];

    $makeId = null;
    foreach ($marcas as $marcaItem) {
        if (strcasecmp($marcaItem['MakeName'], $marcaSeleccionada) == 0) {
            $makeId = $marcaItem['MakeId'];
            break;
        }
    }

    if ($makeId) {
        $apiUrlModelos = "https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMakeId/{$makeId}?format=json";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrlModelos);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuestaModelos = curl_exec($curl);
        curl_close($curl);

        $datosModelos = json_decode($respuestaModelos, true);
        $modelos = array_column($datosModelos['Results'], 'Model_Name');

        echo json_encode($modelos);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>