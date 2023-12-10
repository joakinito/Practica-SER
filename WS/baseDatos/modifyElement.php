<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once('../conexion/Conexion.php');
require_once('../Consulta/Consulta.php');

$conexion = new Conexion("localhost", "root", "qwerty.1234", "monfab", 3309);
$consulta = new Consulta($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $nuevoDatos = json_decode(file_get_contents("php://input"), true);
    header('Content-type: application/json');



    $id = isset($_GET['id']) ? $_GET['id'] : null;


    $resultado = $consulta->modificarElemento($id, $nuevoDatos);

    echo $resultado;
} else {
    echo "Método no permitido";
}
?>