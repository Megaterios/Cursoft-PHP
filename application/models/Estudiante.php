<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:23 AM
 */

require_once '/../libs/baseDatos.php';

class Estudiante extends Usuario {

private $reciboMatricula;
private $estado;


    function __construct(){

    }

    function crear($reciboMatricula, $estado){

        $this->reciboMatricula = $reciboMatricula;
        $this->estado = $estado;
    }

    /**
     * @param mixed $nombre
     */
    public function setReciboMatricula($reciboMatricula){
        $this->reciboMatricula = $reciboMatricula;
        $this->actualizar('nombre', $this->getNombre());
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }



























































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































} 