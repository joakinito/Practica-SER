<?php

/**
 * @author joaki 
 */
include_once "models/Element.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST["nombre_elemento"];
    $descripcion = $_POST["descripcion_elemento"];
    $numeroSerie = $_POST["numero_serie"];
    $estado = $_POST["estado"];
    $prioridad = $_POST["prioridad"];

    // Crea una instancia de la clase Element
    $element = new Element($nombre, $descripcion, $numeroSerie, $estado, $prioridad);

    // Almacena los datos del elemento en un archivo de texto sin sobrescribir el contenido
    try {
        $archivo = 'Formulario.txt';
        if (file_exists($archivo)) {
            $datosExistentes = file_get_contents($archivo);
            $datosJSON = json_decode($datosExistentes);
            $datosJSON[] = $element;
            file_put_contents($archivo, json_encode($datosJSON));
        }
        echo $element->toJson();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}