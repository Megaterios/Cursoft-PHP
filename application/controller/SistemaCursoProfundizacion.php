<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:46 AM
 */

date_default_timezone_set('America/Bogota');

require_once '/../models/Usuario.php';

class SistemaCursoProfundizacion {

    private $modelo;
    private $vista;

    public function __construct() {

    }

    public function iniciarSesion($correo, $contraseña, $tipoUsuario) {
       // $this->validarDatos($correo, $contraseña, $tipoUsuario);

        $this->modelo = new Usuario();
        $this->modelo->obtener($correo);

        if ($correo == $this->modelo->getCorreo() && md5($contraseña) == $this->modelo->getContrasenia()) {
            session_start ();
            $_SESSION ['correo'] = $this->modelo->getCorreo();
            $_SESSION ['tipo'] = "Aspirante";
            //$this->vista = new vista();
            //$this->vista->delegar_vista();
            echo "El señor ".$_SESSION['correo']." ha iniciado sesión";
        }else {
            //$this->vista = new vista();
            //$this->vista->vista();
            echo "No inició sesión";
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
    private function ValidarDatos($correo, $contraseña, $tipo_usuario) {

        $this->vista = new vista();

        if (empty($correo)) {
            $this->vista->retornar_vista('crear',
                array('MENSAJE_CAMPO_VACIO_CODIGO'=>MENSAJE_CAMPO_VACIO_CODIGO,
                    'MENSAJE_CAMPO_VACIO_CONTRASENIA'=>'',
                    'MENSAJE_DATOS_INCORRECTOS'=>'',
                    'TITULO'=>'Error'
                ));
            exit;
        }

        if (strpos($correo, '115') === false && strpos($correo, '015') === false) {
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

    public function recuperarContraseña($correo) {
        //ValidarDatos()

        $this->modelo = new Usuario();
        $this->modelo->obtener($correo);

        if($correo != $this->modelo->getCorreo()) {
            echo "Malo el correo no coincide";
            echo md5('123');
            exit;
        }

        $contrasenia = $this->generarContrasenia();

        $this->modelo->setContrasenia(md5($contrasenia));

        $this->enviarCorreo($this->modelo->getCorreo(), 'Cambio de Contraseña - Provisional', $contrasenia);
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
        if(mail($correoDestinatario, $asunto, $body, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: Cursoft <cursoft@noreply.com>\r\n")) {
            echo "<br>El correo ha sido enviado a ".$correoDestinatario;
        }else {
                echo "<br>El correo no ha sido enviado.";
        }
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