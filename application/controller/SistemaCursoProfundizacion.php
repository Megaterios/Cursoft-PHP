<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:46 AM
 */

namespace application\controller;


class SistemaCursoProfundizacion {

    private $modelo;
    private $vista;

    public function __construct() {

    }

    public function iniciarSesion($correoElectronico, $contraseña, $tipoUsuario) {
        $this->validarDatos($correoElectronico, $contraseña, $tipoUsuario);


    }

    /**
     * Encargado de validar los datos de entrada.
     *
     * Valida los datos de entrada e imprime la vista correspondiente en cada
     * caso de error, si no hay ningun error no realizar ninguna acción en caso
     * contrario imprime la vista pertinente con el mensaje ideal y detiene la
     * aplicación.
     *
     * @param String $correoElectronico
     * @param String $tipo_usuario
     * @param String $contraseña
     */
    private function ValidarDatos($correoElectronico, $contraseña, $tipo_usuario) {

        $this->vista = new vista();

        if (empty($correoElectronico)) {
            $this->vista->retornar_vista('crear',
                array('MENSAJE_CAMPO_VACIO_CODIGO'=>MENSAJE_CAMPO_VACIO_CODIGO,
                    'MENSAJE_CAMPO_VACIO_CONTRASENIA'=>'',
                    'MENSAJE_DATOS_INCORRECTOS'=>'',
                    'TITULO'=>'Error'
                ));
            exit;
        }

        if (strpos($correoElectronico, '115') === false && strpos($correoElectronico, '015') === false) {
            $this->vista->retornar_vista('crear',
                array('MENSAJE_CAMPO_VACIO_CODIGO'=>MENSAJE_CODIGO_NO_SISTEMAS,
                    'MENSAJE_CAMPO_VACIO_CONTRASENIA'=>'',
                    'MENSAJE_DATOS_INCORRECTOS'=>'',
                    'TITULO'=>'Error'
                ));
            exit;
        }

        if (empty($contraseña)) {
            $this->vista->retornar_vista('crear',
                array('MENSAJE_CAMPO_VACIO_CODIGO'=>'',
                    'MENSAJE_CAMPO_VACIO_CONTRASENIA'=>MENSAJE_CAMPO_VACIO_CONTRASENIA,
                    'MENSAJE_DATOS_INCORRECTOS'=>'',
                    'TITULO'=>'Error'
                ));
            exit;
        }

    }

    public function recuperarContraseña() {


    }


    /**
     * Cierra la sesión actual.
     *
     * Destruye el identificador de la sesión y también destrueye completamente la sesión,
     * en caso de realizar esto sin inconvenientes retorna true de lo contrario retorna
     * false.
     *
     * @return boolean
     */
    public function cerrarSesion() {
        if(isset($_SESSION['correoElectronico'])) {
            unset($_SESSION['correoElectronico']);
            session_unset();
            session_destroy();
            return true;
        }
        return false;
    }


} 