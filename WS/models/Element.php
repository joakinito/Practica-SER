<?php
/**
 * @author joaki 
 */

require_once('interfaces/IToJson.php');
class Element implements IToJson
{
    public $nombre_elemento;
    public $descripcion_elemento;
    public $numero_serie;
    public $estado;
    public $prioridad;

    public function __construct($nombre, $descripcion, $numeroSerie, $estado, $prioridad)
    {
        $this->nombre_elemento = $nombre;
        $this->descripcion_elemento = $descripcion;
        $this->numero_serie = $numeroSerie;
        $this->estado = $estado;
        $this->prioridad = $prioridad;
    }
    //Get
    public function getNombreElemento()
    {
        return $this->nombre_elemento;
    }

    public function getDescripcionElemento()
    {
        return $this->descripcion_elemento;
    }

    public function getNumeroSerie()
    {
        return $this->numero_serie;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getPrioridad()
    {
        return $this->prioridad;
    }

    // Set
    public function setNombreElemento($nombre)
    {
        $this->nombre_elemento = $nombre;
    }

    public function setDescripcionElemento($descripcion)
    {
        $this->descripcion_elemento = $descripcion;
    }

    public function setNumeroSerie($numeroSerie)
    {
        $this->numero_serie = $numeroSerie;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
    }
    public function toJson()
    {
        return json_encode($this);
    }
}
