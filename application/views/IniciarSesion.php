<?php
/**
 * Created by PhpStorm.
 * User: Yeison
 * Date: 5/21/14
 * Time: 7:24 AM
 */

require_once('/../libs/Vista.php');

class IniciarSesion extends Vista {

    function __construct($tipo, $datos=array(), $mensaje, $reenderizarPlantillaBase)
    {

        if($tipo == 'error' || $tipo == 'exito') {
            $this->obtenerPlantilla($tipo);
            $this->datos = array('MENSAJE'=>$mensaje);
            $this->renderizarDatos();
        }

        $datos['DIV'] = $this->plantilla;
        $this->plantilla = "";

        $this->retornarVista('iniciar_sesion', $datos, $reenderizarPlantillaBase);
    }
}