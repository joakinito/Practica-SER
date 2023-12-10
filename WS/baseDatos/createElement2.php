<?php
require_once('../conexion/Conexion.php');
require_once('../Consulta\Consulta.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$conexion = new Conexion("localhost", "root", "qwerty.1234", "monfab", 3309);
$consulta = new Consulta($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = json_decode(file_get_contents("php://input"), true);
    header('Content-type: application/json');
    $resultado = $consulta->insertarElemento($datos);
    echo $resultado;
}




