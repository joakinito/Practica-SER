<?php

/**
 * @author joaki 
 */
class Conexion
{
    private $conexion;

    public function __construct($direccion, $usuario, $contrasena, $bd, $puerto)
    {
        try {
            $dsn = 'mysql:host=' . $direccion . ';dbname=' . $bd . ';port=' . $puerto;
            $this->conexion = new PDO($dsn, $usuario, $contrasena);
        } catch (PDOException $e) {
            echo 'Error al intentar conectarse a la base de datos: ' . $e->getMessage();
        }
    }

    public function obtenerConexion()
    {
        return $this->conexion;
    }
}
