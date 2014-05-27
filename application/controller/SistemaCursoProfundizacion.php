<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:46 AM
 */

date_default_timezone_set('America/Bogota');

require_once 'application/models/Usuario.php';
require_once 'application/models/Curso.php';
require_once 'application/libs/Vista.php';
require_once 'application/views/IniciarSesion.php';
require_once 'application/views/RecuperarContrasenia.php';
require_once 'application/views/RegistrarAspirante.php';
require_once 'application/views/InicioAspirante.php';


class SistemaCursoProfundizacion {

    private $modelo;
    private $vista;

    public function __construct() {

    }


    public function registrarAspirante($correo, $contrasenia, $confirmacionContrasenia, $nombres, $apellidos,
                                       $tipoDocumento, $numeroDocumento, $fechaNacimiento, $DireccionResidencia,
                                       $TelefonoResidencia, $telefonoMovil, $codigo, $promedioPonderado,
                                       $semestreTerminacionMaterias, $reciboTerminacionMaterias, $reciboPazSalvo,
                                       $reciboPagoInscripcion) {


        //Validar datos de entrada
          //Genera interfaz con los diferentes errores

        $this->modelo = new Curso();
        $this->modelo->obtenerCurso(1);
        //El curso está ?
            //No, genere vista de error



        $mensaje = $this->modelo->registrarAspirante($correo, $contrasenia, $confirmacionContrasenia, $nombres, $apellidos,
            $tipoDocumento, $numeroDocumento, $fechaNacimiento, $DireccionResidencia,
            $TelefonoResidencia, $telefonoMovil, $codigo, $promedioPonderado,
            $semestreTerminacionMaterias, $reciboTerminacionMaterias, $reciboPazSalvo,
            $reciboPagoInscripcion);

        if($mensaje[0] == true) {
            $this->vista = new IniciarSesion('exito', $datos = array(
                'CLASS_CORREO'=>COLOR_DEFECTO,
                'CLASS_CONTRASENIA'=>COLOR_DEFECTO
            ), $mensaje[1]);
        }else {
            $this->vista = new RegistrarAspirante('error', $datos=array(
                'DIV'=>'',
                'CLASS_CORREO'=>COLOR_ROJO,
                'CLASS_CONTRASENIA'=>COLOR_ROJO,
                'CLASS_CONFIRMAR_CONTRASENIA'=>COLOR_ROJO,
                'CLASS_NOMBRES'=>COLOR_ROJO,
                'CLASS_APELLIDOS'=>COLOR_ROJO,
                'CLASS_TIPO_DOCUMENTO'=>COLOR_ROJO,
                'CLASS_NUMERO_DOCUMENTO'=>COLOR_ROJO,
                'CLASS_FECHA_NACIMIENTO'=>COLOR_ROJO,
                'CLASS_DIRECCION_RESIDENCIA'=>COLOR_ROJO,
                'CLASS_TELEFONO_RESIDENCIA'=>COLOR_ROJO,
                'CLASS_TELEFONO_MOVIL'=>COLOR_ROJO,
                'CLASS_CODIGO'=>COLOR_ROJO,
                'CLASS_PROMEDIO_PONDERADO'=>COLOR_ROJO,
                'CLASS_SEMESTRE_TERMINACION_MATERIAS'=>COLOR_ROJO,
                'CLASS_RECIBO_TERMINACION_MATERIAS'=>COLOR_ROJO,
                'CLASS_RECIBO_PAZ_SALVO'=>COLOR_ROJO,
                'CLASS_RECIBO_PAGO_INSCRIPCION'=>COLOR_ROJO,
                'CLASS_BOTONES'=>COLOR_ROJO
            ), $mensaje[1]);
            exit;
        }


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
        if ($correo == $this->modelo->getCorreo() && md5($contrasenia) == $this->modelo->getContrasenia() &&
            $tipoUsuario == $this->modelo->getTipo()) {
            if(!session_id()) session_start();
            echo "Inicie sesion";
            $_SESSION ['correo'] = $this->modelo->getCorreo();
            $_SESSION ['idUsuario'] = $this->modelo->getIdUsuario();
            $_SESSION ['tipo'] = $this->modelo->getTipo();
            $_SESSION ['codigo'] = $this->modelo->getCodigo();

            if($this->modelo->getTipo() == '1') {
                $this->modelo = new Aspirante();
                $this->modelo->obtenerAspirante($_SESSION ['codigo']);


                switch($this->modelo->getEstado()) {

                    //Pendiente
                    case 0:

                        echo "Este es el codigo ".$this->modelo->getCodigo();
                        $this->vista = new InicioAspirante('Aprobado', $datos = array(
                                'TIPO'=> $this->modelo->getTipo(),
                                'NOMBRE'=>$this->modelo->getNombre() . $this->modelo->getApellido(),
                                'CODIGO'=>$this->modelo->getCodigo(),
                                'ESTADO'=>'Aprobado'
                        ), MENSAJE_APROBADO

                        );

exit;
                        break;

                    //Aprobado
                    case 1:

                        $this->vista = new InicioAspirante('Pendiente', $datos = array(
                                'TIPO'=> $this->modelo->getTipo(),
                                'NOMBRE'=>$this->modelo->getNombre() . $this->modelo->getApellido(),
                                'CODIGO'=>$this->modelo->getCodigo(),
                                'ESTADO'=>'Pendiente'

                            ), MENSAJE_PENDIENTE

                        );


                        break;

                    //Rechazado
                    case 2:


                        $this->vista = new InicioAspirante('Rechazado', $datos = array(
                                'TIPO'=> $this->modelo->getTipo(),
                                'NOMBRE'=>$this->modelo->getNombre() . $this->modelo->getApellido(),
                                'CODIGO'=>$this->modelo->getCodigo(),
                                'ESTADO'=>'Pendiente'

                            ), MENSAJE_RECHAZADO

                        );

                        break;
                }


            }
            /*
             * Tipos:
             *
             * Aspirante
             * --Aprobado
             * --Pendiente
             * --rechazado
             * Estudiante
             * --Pendiente (Aspirante carga pago de la matricula)
             * --Rechazado (Cargo mal el pago de la matricula, foto de novia)
             * --Aprobado
             * Docente
             *
             *
             */







            //$this->vista = new vista();
            //$this->vista->delegar_vista();


            echo "El señor ".$_SESSION['correo']." ha iniciado sesión";
        }else {
            $this->vista = new IniciarSesion('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO,
                'CLASS_CONTRASENIA'=>COLOR_ROJO,
            ), CU2_ERROR_4);
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
            ), CU2_ERROR_1);
            exit;
        }

        if (empty($correo)) {
            $this->vista = new IniciarSesion('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO,
                'CLASS_CONTRASENIA'=>COLOR_DEFECTO,
                ), CU2_ERROR_2);
            exit;
        }

        if (empty($contrasenia)) {
            $this->vista = new IniciarSesion('error', $datos = array(
                'CLASS_CORREO'=>COLOR_DEFECTO,
                'CLASS_CONTRASENIA'=>COLOR_ROJO,
            ), CU2_ERROR_3);
            exit;
        }
    }

    private function validarDatosRecuperarContrasenia() {

    }

    public function recuperarContrasenia($correo) {
        if (empty($correo)) {
            $this->vista = new RecuperarContrasenia('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO
            ), CU3_ERROR_1);
            exit;
        }

        $this->modelo = new Usuario();
        $this->modelo->obtener($correo);

        if($correo != $this->modelo->getCorreo()) {
            $this->vista = new RecuperarContrasenia('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO
            ), CU3_ERROR_2);
            exit;
        }

        $contrasenia = $this->generarContrasenia();

        $this->modelo->setContrasenia(md5($contrasenia));

        if($this->enviarCorreo($this->modelo->getCorreo(), 'Cambio de Contraseña - Provisional', $contrasenia)) {
                $this->vista = new IniciarSesion('exito', $datos = array(
                    'CLASS_CORREO'=>COLOR_DEFECTO,
                    'CLASS_CONTRASENIA'=>COLOR_DEFECTO
                ), CU3_EXITO);
        }else {
            $this->vista = new RecuperarContrasenia('error', $datos = array(
                'CLASS_CORREO'=>COLOR_ROJO
            ), CU3_ERROR_3);
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
        return(mail($correoDestinatario, $asunto, $body, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: Cursoft <cursoft@sandbox1.com>\r\n"));
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
            ), '');
            exit;
        }

        if($vista == 'IU_REGISTRAR_ASPIRANTE') {
            $this->vista = new RegistrarAspirante('registrar_aspirante', $datos=array(
                'DIV'=>'',
                'CLASS_CORREO'=>COLOR_DEFECTO,
                'CLASS_CONTRASENIA'=>COLOR_DEFECTO,
                'CLASS_CONFIRMAR_CONTRASENIA'=>COLOR_DEFECTO,
                'CLASS_NOMBRES'=>COLOR_DEFECTO,
                'CLASS_APELLIDOS'=>COLOR_DEFECTO,
                'CLASS_TIPO_DOCUMENTO'=>COLOR_DEFECTO,
                'CLASS_NUMERO_DOCUMENTO'=>COLOR_DEFECTO,
                'CLASS_FECHA_NACIMIENTO'=>COLOR_DEFECTO,
                'CLASS_DIRECCION_RESIDENCIA'=>COLOR_DEFECTO,
                'CLASS_TELEFONO_RESIDENCIA'=>COLOR_DEFECTO,
                'CLASS_TELEFONO_MOVIL'=>COLOR_DEFECTO,
                'CLASS_CODIGO'=>COLOR_DEFECTO,
                'CLASS_PROMEDIO_PONDERADO'=>COLOR_DEFECTO,
                'CLASS_SEMESTRE_TERMINACION_MATERIAS'=>COLOR_DEFECTO,
                'CLASS_RECIBO_TERMINACION_MATERIAS'=>COLOR_DEFECTO,
                'CLASS_RECIBO_PAZ_SALVO'=>COLOR_DEFECTO,
                'CLASS_RECIBO_PAGO_INSCRIPCION'=>COLOR_DEFECTO,
                'CLASS_BOTONES'=>COLOR_DEFECTO
            ), '');
            exit;
        }


        if(!isset($_SESSION['correo']) || $_SESSION['correo'] == '') {
            $this->vista = new IniciarSesion('iniciar_sesion', $datos = array(
                'DIV'=>'',
                'CLASS_CORREO'=>COLOR_DEFECTO,
                'CLASS_CONTRASENIA'=>COLOR_DEFECTO,), '');
            exit;
        }

      //  $this->vista->
    }






























































































































































































































































































































































































































































































































































































































































































































































































































    //¡Mi línea!

    /**
     * @param $codigoEstudiante
     */
    public function matricularEstudianteCurso($codigoEstudiante){

        $curso = new Curso();
        $curso->matricularEstudiante($codigoEstudiante);

        //Recargar vista.
    }


    /**
     * @param $idCurso
     */
    public function consultarEstudiantesCurso($idCurso){

        $curso = new Curso();
        $curso->obtenerCurso($idCurso);
        if($curso->getIdCurso() != ''){
            $listadoEstudiantes = $curso->consultarEstudiantes();

            //Imprimir listado.
        }
    }

    /**
     *
     */
    public function evaluarCurso(){

        //Agregar columna "notaEvaluacion" a tabla Curso en BD.



    }

    /**
     *
     */
    public function cargarNotaEstudiante($idCurso, $codigoEstudiante, $nota){

        $curso = new Curso();

        if($curso->getIdCurso() != ''){
            $curso->cargarNotaEstudiante($codigoEstudiante, $nota);

            //Imprimir vista.
        }



    }


    /**
     *
     */
    public function consultarNotasCursoEstudiante($idCurso, $codigoEstudiante){


        $idCurso = 1;
        $idEstudiante = $_SESSION['idEstudiante'];
        $curso = new Curso();

        $curso->obtenerCurso($idCurso);
        $resultadoNotas = array();

        if($curso->getIdCurso() != ''){
            $resultadoNotas = $curso->consultarNotasEstudiante($idEstudiante);
        }

        $registroNotas = '';
        foreach($resultadoNotas as $pos){

            $nombreProfesor = $pos['Usuario.nombre'].$pos['Usuario.apellido'];

            $registroNotas .= '
                            <tr>
                                <td>'.$pos['Modulo.idModulo'].'</td>
                                <td><a href="#">'.$pos['Modulo.nombreModulo'].'</a></td>
                                <td><a href="#">'.$pos['Modulo.nombreProfesor'].'</a></td>
                                <td><a href="#">'.$nombreProfesor.'</a></td>
                                <td>'.$pos['DocenteModuloEstudiante.nota'].'</td>
                            </tr>';

        }

        $this->vista = new InicioEstudianteAprobado('inicio_estudiante_aprobado', $registroNotas);


    }







































































































































































































































































































} 


?>
