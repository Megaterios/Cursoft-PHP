<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:46 AM
 */

date_default_timezone_set('America/Bogota');

require_once '/../models/Usuario.php';
require_once '/../libs/Vista.php';
require_once '/../views/IniciarSesion.php';
require_once '/../views/RecuperarContrasenia.php';

class SistemaCursoProfundizacion {

    private $modelo;
    private $vista;

    public function __construct() {

    }

    /**
     * Método que activa la variable de sesión para que el usuario pueda
     * acceder a las funcionalidades del software que se le encuentran permitidas
     * usar.
     *
     * @param $correo: cadena que corresponde al correo electrónico con el que se registró.
     * @param $contrasenia: cadena que sirve para realizar la autenticación en el sistema.
     * @param $tipoUsuario: número que indica si es aspirante, estudiante o docente.
     */
    public function iniciarSesion($correo, $contrasenia, $tipoUsuario) {
        $this->validarDatosIniciarSesion($correo, $contrasenia, $tipoUsuario);
        $this->modelo = new Usuario();
        $this->modelo->obtener($correo);
        if ($correo == $this->modelo->getCorreo() && md5($contrasenia) == $this->modelo->getContrasenia()) {
            session_start ();
            $_SESSION ['correo'] = $this->modelo->getCorreo();
            $_SESSION ['tipo'] = $tipoUsuario;
            //$this->vista = new vista();
            //$this->vista->delegar_vista();


            echo "El señor ".$_SESSION['correo']." ha iniciado sesión";
        }else {
            $this->vista = new IniciarSesion('iniciar_sesion_error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO,
                'CLASS_CONTRASENIA'=>COLOR_ROJO,
            ), CU2_ERROR_4, false);
            exit;
        }

    }


    /**
     * Encargado de validar los datos de entrada.
     *
     * Valida los datos de entrada e imprime la vista correspondiente en cada
     * caso de error, si no hay ningun error no realizar ninguna acción en caso
     * contrario imprime la vista pertinente con el mensaje ideal y detiene la
     * aplicación.
     *
     * @param String $correo
     * @param String $tipo_usuario
     * @param String $contraseña
     */
    private function validarDatosIniciarSesion($correo, $contrasenia, $tipo_usuario) {

        if (empty($correo) && empty($contrasenia)) {
            $this->vista = new IniciarSesion('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO,
                'CLASS_CONTRASENIA'=>COLOR_ROJO,
            ), CU2_ERROR_1, false);
            exit;
        }

        if (empty($correo)) {
            $this->vista = new IniciarSesion('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO,
                'CLASS_CONTRASENIA'=>COLOR_DEFECTO,
                ), CU2_ERROR_2, false);
            exit;
        }

        if (empty($contrasenia)) {
            $this->vista = new IniciarSesion('error', $datos = array(
                'CLASS_CORREO'=>COLOR_DEFECTO,
                'CLASS_CONTRASENIA'=>COLOR_ROJO,
            ), CU2_ERROR_3, false);
            exit;
        }
    }

    private function validarDatosRecuperarContrasenia() {

    }

    public function recuperarContrasenia($correo) {
        if (empty($correo)) {
            $this->vista = new RecuperarContrasenia('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO
            ), CU3_ERROR_1, false);
            exit;
        }

        $this->modelo = new Usuario();
        $this->modelo->obtener($correo);

        if($correo != $this->modelo->getCorreo()) {
            $this->vista = new RecuperarContrasenia('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO
            ), CU3_ERROR_2, false);
            exit;
        }

        $contrasenia = $this->generarContrasenia();

        $this->modelo->setContrasenia(md5($contrasenia));

        echo "Aca voy a cambiar contraseña";
        if($this->enviarCorreo($this->modelo->getCorreo(), 'Cambio de Contraseña - Provisional', $contrasenia)) {
                $this->vista = new IniciarSesion('exito', $datos = array(
                    'CLASS_CORREO'=>COLOR_DEFECTO,
                    'CLASS_CONTRASENIA'=>COLOR_DEFECTO
                ), CU3_EXITO, false);
        }else {
            $this->vista = new RecuperarContrasenia('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO
            ), CU3_ERROR_3, false);
        }
        $contrasenia = null;
    }


    public function cambiarContrasenia($contraseniaNueva) {
        //ValidarDatos()
        /**
         *         if(empty($contraseniaNueva) {
        imprimir view
        return;
        }
        if(strlen($contraseniaNueva)<=6) {
        imprimir view
        return;
        }
        if(strcmp($nueva_clave, $confirmacion_nueva_clave) !== 0) {
        imprimir view
        return;
        }
         */
        //Debe tener la sesión iniciada - Validar

        $this->modelo = new Usuario();
        $this->modelo->obtener($_SESSION['correo']);

        if($_SESSION['correo'] != $this->modelo->getCorreo()) {
            echo '<br>El correo no está registrado, Algo ilógico casi nunca se daria porque se supone que inició sesión porque estaba
            a no ser de que lo borren por base de datos o exista una inconsistencia de información';
            exit;
        }

        $this->modelo->setContrasenia(md5($contraseniaNueva));
        $this->enviarCorreo($this->modelo->getCorreo(), 'Su contraseña ha sido cambiada', 'El dia x-y-z a las hora x:o, se cambió su clave');
    }


    private function generarContrasenia() {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmno;{}*pqrstuvwxyz123456789.0";
        $cad = "";
        for($i=0;$i<12;$i++) {
            $cad .= substr($str,rand(0,67),1);
        }
        return $cad;
    }


    public function consultarDatos() {
        $this->modelo = new Usuario();
        $this->modelo->obtenerDatos($_SESSION['correo'], $_SESSION['tipo']);
       //$this->modelo->obtener($_SESSION['correo']);
        echo $this->modelo->__toString();

    }

    private function actualizarDatos() {

    }

    private function eliminarEstudiante() {

    }



    private function enviarCorreo($correoDestinatario, $asunto, $body) {
        return(mail($correoDestinatario, $asunto, $body, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: Cursoft <cursoft@noreply.com>\r\n"));
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
        if(isset($_SESSION['correo'])) {
            unset($_SESSION['correo']);
            session_unset();
            session_destroy();
            return true;
        }
        return false;
    }

    public function cargarVista($vista = '') {
        if($vista == 'IU_RECUPERAR_CONTRASENIA') {
            $this->vista = new RecuperarContrasenia('recuperar_contrasenia', $datos=array(
                'DIV'=>'',
                'CLASS_CORREO'=>COLOR_DEFECTO,
            ), '', false);
            exit;
        }

        if(!isset($_SESSION['correo']) || $_SESSION['correo'] == '') {
            $this->vista = new IniciarSesion('iniciar_sesion', $datos = array(
                'DIV'=>'',
                'CLASS_CORREO'=>COLOR_DEFECTO,
                'CLASS_CONTRASENIA'=>COLOR_DEFECTO,), '', false);
            exit;
        }

      //  $this->vista->
    }






























































































































































































































































































































































































































































































































































































































































































































































































































    //¡Mi línea!

    public function matricularEstudianteCurso($codigoEstudiante){

        $curso = new Curso();
        $curso->matricularEstudiante($codigoEstudiante);

        //Recargar vista.
    }

    public function consultarEstudiantesCurso($idCurso){

        $curso = new Curso();
        $curso->obtenerCurso($idCurso);
        $listadoEstudiantes = $curso->consultarEstudiantes($idCurso);

        //Imprimir listado.
    }




































































































































































































































































































} 


?>