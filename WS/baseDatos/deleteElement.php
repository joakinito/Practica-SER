<?php
require_once('../conexion/Conexion.php');
require_once('../Consulta\Consulta.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$conexion = new Conexion("localhost", "root", "qwerty.1234", "monfab", 3309);
$consulta = new Consulta($conexion);

$id = isset($_GET['id']) ? $_GET['id'] : null;

echo $consulta->eliminarElemento($id);
