<?php
/**
 * Created by PhpStorm.
 * User: Yeison
 * Date: 5/25/14
 * Time: 4:28 PM
 */

require_once('application/libs/Vista.php');

class ConsultarDatos extends Vista {

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

      //  print_r($datos);

        $this->generarMenu();
        $datos['MENU'] = $this->plantilla;
        $this->plantilla = "";

        $this->generarMigasPan($_SESSION['codigo'], $_SESSION['nombre']);
        $datos['MIGAS_PAN'] = $this->plantilla;
        $this->plantilla = "";

        $datos ['MENSAJE'] = $mensaje;
        $this->retornarVista('consultar_aspirante', $datos);

    }


    private function getTipo() {
        if($_SESSION['tipo'] == 1) {
            return 'Aspirante';
        }

        if($_SESSION['tipo'] == 2) {
            return 'Docente';
        }

        return 'Estdiante';
    }

    private function generarMenu() {
        $this->obtenerPlantilla("menu");

        $this->datos = array(
            'TIPO'=>$this->getTipo(),
            'FUNCIONES'=>USUARIO_CONSULTAR_ACTIVA.USUARIO_ACTUAIZAR,
            'URL_TIPO'=>'index.php'
        );
        $this->renderizarDatos();
    }


    private function generarMigasPan($codigo, $nombre) {
        $this->obtenerPlantilla("migas_pan");
        $this->datos = array(
            'TIPO'=>$this->getTipo(),
            'FUNCION_ACTUAL'=>USUARIO_CONSULTAR_ACTIVA,
            'CODIGO'=>$codigo,
            'NOMBRE'=>$nombre
        );
        $this->renderizarDatos();

    }


} 