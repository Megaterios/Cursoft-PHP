<?php
/**
 * Created by PhpStorm.
 * User: Yeison
 * Date: 5/21/14
 * Time: 7:16 AM
 */

require_once 'application/config/config.php';

class Vista {

    protected $plantilla;
    protected $datos;
    private $datosFormularioBase;

    function __construct(){

        $this->datosFormularioBase = array(
            'SECTION'=>''
        );
    }


    protected function obtenerPlantilla($form) {
        $ruta = "public/".$form.".html";
        $this->plantilla = file_get_contents($ruta);
    }

    protected function renderizarDatos() {
        foreach ($this->datos as $clave => $valor) {
            $this->plantilla = str_replace('['.$clave.']', $valor, $this->plantilla);
        }
    }

    protected function retornarVista($vista, $datos=array()) {
        $this->obtenerPlantilla($vista);
        $this->datos = $datos;
        $this->renderizarDatos();

        $this->datosFormularioBase['SECTION'] = $this->plantilla;
        $this->obtenerPlantilla('template_base');

            $this->datos = $this->datosFormularioBase;
            $this->renderizarDatos();

        print $this->plantilla;
    }

} 