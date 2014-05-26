<?php
/**
 * Created by PhpStorm.
 * User: Yeison
 * Date: 5/21/14
 * Time: 10:20 PM
 */

class RecuperarContrasenia extends Vista {


    function __construct($tipo, $datos=array(), $mensaje)
    {
        parent::__construct();
        if($tipo == 'error') {
            $this->obtenerPlantilla($tipo);
            $this->datos = array('MENSAJE'=>$mensaje);
            $this->renderizarDatos();
        }

        $datos['DIV'] = $this->plantilla;
        $this->plantilla = "";

        $this->retornarVista('recuperar_contrasenia', $datos);
    }

} 