<?php
/**
 * @author joaki 
 */
require_once('../conexion/Conexion.php');
require_once('../Consulta\Consulta.php');

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
$conexion = new Conexion("localhost", "root", "qwerty.1234", "monfab", 3309);
$consulta = new Consulta($conexion);

$id = isset($_GET['id']) ? $_GET['id'] : null;

$resultados = $consulta->obtenerElementos($id);


echo $resultados;