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

       // print_r($datos);

        $this->generarMenu();
        $datos['MENU'] = $this->plantilla;
        $this->plantilla = "";


        $this->generarMigasPan($datos['CODIGO'], $datos['NOMBRE']);
        $datos['MIGAS_PAN'] = $this->plantilla;
        $this->plantilla = "";

        $datos ['MENSAJE'] = $mensaje;
        $this->retornarVista('inicio_aspirante', $datos);

    }


    private function generarMenu() {
        $this->obtenerPlantilla("menu");
        $this->datos = array(
            'TIPO'=>'Aspirante',
            'URL_TIPO'=>'index.php',
            'FUNCIONES'=>ASPIRANTE_FUNCION_1
        );
        $this->renderizarDatos();
    }


    private function generarMigasPan($codigo, $nombre) {
        $this->obtenerPlantilla("migas_pan");
        $this->datos = array(
            'TIPO'=>'Aspirante',
            'FUNCION_ACTUAL'=>'',
            'CODIGO'=>$codigo,
            'NOMBRE'=>$nombre
        );
        $this->renderizarDatos();

    }


} 