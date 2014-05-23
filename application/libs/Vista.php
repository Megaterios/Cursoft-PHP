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
            'TITULO_VENTANA'=>'Comfaoriente EPSS',
            'FUNCION'=>'Ingresar' ,
            'INICIO'=> '',
            'INGRESAR'=> '',
            'REGISTRAR'=> '',
            'CONTACTENOS'=>'',
            'RECUPERAR'=>'',
            'CAMBIAR'=>'',
            'BIENVENIDA'=>'',
            'FUNCIONES DISPONIBLES PARA '=>'',
            'CARGAR'=>'',
            'ERROR'=>'',
            'HTTP'=>HTTP,
            'NOMBRE_URL_1'=>'Salir',
            'URL_1'=>HTTP.'/login/index.php?accion=cerrarSesion',
            'NOMBRE_URL_2'=>'Validador',
            'URL_2'=>HTTP.'/login/index.php'
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

    protected function retornarVista($vista, $datos=array(), $reenderizarPlantillaBase) {
        $this->obtenerPlantilla($vista);
        $this->datos = $datos;
        $this->renderizarDatos();
        if($reenderizarPlantillaBase) {
            $this->datos = $this->datosFormularioBase;
            $this->renderizarDatos();
        }

        print $this->plantilla;
    }

} 