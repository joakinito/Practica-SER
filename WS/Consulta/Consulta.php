<?php
/**
 * @author joaki 
 */



require_once('../conexion/Conexion.php');

class Consulta
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion->obtenerConexion();
    }
    public function enviarRespuesta($success, $message, $data)
    {
        return json_encode(
            [
                "success" => $success,
                "message" => $message,
                "data" => $data
            ]
        );
    }

    public function eliminarElemento($id)
    {
        try {
            if (!empty($id)) {
                $elementoExistente = $this->obtenerElementos($id);
                $consulta = $this->conexion->prepare("DELETE FROM elementos WHERE id = :id");
                $consulta->bindParam(':id', $id, PDO::PARAM_INT);
                $consulta->execute();
                $obtenerElemento = json_decode($elementoExistente, true);
                $datosElemento = $obtenerElemento['data'];
                return $this->enviarRespuesta(true, "Elemento eliminado correctamente", $datosElemento);
            } else {
                return $this->enviarRespuesta(false, "No has añadido ninguna id que eliminar", null);
            }
        } catch (Exception $e) {
            return $this->enviarRespuesta(false, $e->getMessage(), null);
        }
    }


    public function obtenerElementos($id)
    {

        try {

            if (!empty($id)) {
                $consulta = $this->conexion->prepare("SELECT * FROM elementos WHERE id = :id");
                $consulta->bindParam(':id', $id, PDO::PARAM_INT);
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                if ($resultados == null) {
                    return $this->enviarRespuesta(false, "Id no encontrada en la base de datos", null);
                }
                return $this->enviarRespuesta(true, "Estas en la id: $id", $resultados);

            } else {
                $consulta = $this->conexion->prepare("SELECT * FROM elementos");
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $this->enviarRespuesta(true, "base de datos completa", $resultados);
            }

        } catch (Exception $e) {
            return $this->enviarRespuesta(false, "Error en la consulta", null);
        }
    }


    public function insertarElemento($datos)
    // Esto lo añades en mysql ALTER TABLE elemento MODIFY columna VARCHAR(255) DEFAULT NULL;
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($datos)) {
                return $this->enviarRespuesta(false, "Error en el post", null);
            }

            $columnas = implode(', ', array_keys($datos));
            $valores = ':' . implode(', :', array_keys($datos));
            $consulta = $this->conexion->prepare("INSERT INTO elementos ($columnas) VALUES ($valores)");

            foreach ($datos as $clave => $valor) {
                $consulta->bindValue(':' . $clave, $valor);
            }

            $exito = $consulta->execute();
            $idInsertado = $this->conexion->lastInsertId();
            $elementoExistente = $this->obtenerElementos($idInsertado);
            $obtenerElemento = json_decode($this->obtenerElementos($idInsertado), true);
            $datosElemento = $obtenerElemento['data'];
            return $this->enviarRespuesta(true, "Elemento insertado correctamente", $datosElemento);


        } catch (Exception $e) {
            return $this->enviarRespuesta(false, $e->getMessage(), null);
        }
    }


    public function modificarElemento($id, $nuevosDatos)
    {
        try {
            if ($id === null) {
                return $this->enviarRespuesta(false, "ID no válido", null);
            }

            $actualizar = "UPDATE elementos SET nombre = :nombre, descripcion = :descripcion, nserie = :nserie, estado = :estado, prioridad = :prioridad WHERE id = :id";

            $consulta = $this->conexion->prepare($actualizar);

            $consulta->bindParam(':nombre', $nuevosDatos['nombre']);
            $consulta->bindParam(':descripcion', $nuevosDatos['descripcion']);
            $consulta->bindParam(':nserie', $nuevosDatos['nserie']);
            $consulta->bindParam(':estado', $nuevosDatos['estado']);
            $consulta->bindParam(':prioridad', $nuevosDatos['prioridad']);
            $consulta->bindParam(':id', $id);

            $consulta->execute();


            $obtenerElemento = json_decode($this->obtenerElementos($id), true);
            $datosElemento = $obtenerElemento['data'];
            echo $nuevosDatos['nombre'];
            return $this->enviarRespuesta(true, "Elemento modificado correctamente", $datosElemento);
        } catch (Exception $e) {
            return $this->enviarRespuesta(false, $e->getMessage(), null);
        }
    }


}