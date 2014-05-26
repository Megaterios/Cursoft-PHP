<?php
/**
 * Created by PhpStorm.
 * User: Yeison
 * Date: 5/25/14
 * Time: 4:28 PM
 */

require_once('application/libs/Vista.php');

class InicioAspirante extends Vista {

    function __construct($tipo, $datos=array(), $mensaje)
    {
        parent::__construct();
        /*
                if($tipo == 'aprobado' || $tipo == 'pendiente' || $tipo == 'rechazado') {
                    $this->obtenerPlantilla("inicio_aspirante_".$tipo);
                    $this->datos = array('MENSAJE'=>$mensaje);
                    $this->renderizarDatos();
                }

                $datos['DIV'] = $this->plantilla;
                $this->plantilla = "";
        */

        $this->obtenerPlantilla("menu");
        $this->renderizarDatos();
        $datos['MENU'] = $this->plantilla;
        $this->plantilla = "";

        $this->obtenerPlantilla("migas_pan");
        $this->renderizarDatos();

        $datos['MIGAS_PAN'] = $this->plantilla;
        $this->plantilla = "";

        $this->retornarVista('inicio_aspirante', $datos);

    }


} 