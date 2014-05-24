<?php
/**
 * Created by PhpStorm.
 * User: Yeison
 * Date: 5/24/14
 * Time: 10:14 AM
 */

class RegistrarAspirante extends Vista {

    function __construct($tipo, $datos=array(), $mensaje)
    {
        if($tipo == 'error' || $tipo == 'exito') {
            $this->obtenerPlantilla($tipo);
            $this->datos = array('MENSAJE'=>$mensaje);
            $this->renderizarDatos();
        }

        $datos['DIV'] = $this->plantilla;
        $this->plantilla = "";

        $this->retornarVista('registrar_aspirante', $datos);
    }

} 