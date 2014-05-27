<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:20 AM
 */

require_once ('application/libs/baseDatos.php');
require_once ('application/config/config.php');
require_once ('application/models/Aspirante.php');

class Curso extends baseDatos {

    private $idCurso;
    private $nombre;
    private $fechaInicio;
    private $fechaFin;
    private $resolucion;


    function __construct(){

    }

    function crear($nombre, $fechaInicio, $fechaFin, $resolucion){

        $this->idCurso = '';
        $this->nombre = $nombre;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->resolucion = $resolucion;

    }

    public function inicializar() {
        $this->idCurso = '';
        $this->nombre = '';
        $this->fechaInicio = '';
        $this->fechaFin = '';
        $this->resolucion = '';
    }


    public function setIdCurso($idCurso){
        $this->idCurso = $idCurso;
        $this->actualizar('idCurso', $this->idCurso);
    }

    /**
     * @return mixed
     */
    public function getIdCurso()
    {
        return $this->idCurso;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre){
        $this->nombre = $nombre;
        $this->actualizar('nombre', $this->nombre);
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }


    /**
     * @param mixed $nombre
     */
    public function setFechaInicio($fechaInicio){
        $this->fechaInicio = $fechaInicio;
        $this->actualizar('fechaInicio', $this->fechaInicio);
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }


    public function setFechaFin($fechaFin){
        $this->fechaFin = $fechaFin;
        $this->actualizar('fechaFin', $this->fechaFin);
    }

    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    public function registrarAspirante($correo, $contrasenia, $confirmacionContrasenia, $nombres, $apellidos,
                                       $tipoDocumento, $numeroDocumento, $fechaNacimiento, $direccionResidencia,
                                       $telefonoResidencia, $telefonoMovil, $codigo, $promedioPonderado,
                                       $semestreTerminacionMaterias, $reciboTerminacionMaterias, $reciboPazSalvo,
                                       $reciboPagoInscripcion) {

        $reciboTerminacionMaterias = 'reciboterminacion';
        $reciboPazSalvo = 'recibopazsalvo';
        $reciboPagoInscripcion = 'recibopagoinsc';

        $aspirante = new Aspirante();
        $aspirante->obtenerAspirante('codigo', $codigo);

        if($aspirante->getIdAspirante() != ''){//Ya aspiró al curso de profundizacion y fue estudiante como 1 y 2*/) {
            //retornar el mensaje de que ya hasido aspirante a este curso.

            return array(0=>false, 1=>'Ya se encuentra registrado un aspirante con el código ingresado');

        }

        echo '<br>Correo ingresado:'.$correo.'</br>';
        $aspirante->obtenerAspirante('correo', $correo);
        echo '<br>Correo obtenido:'.$aspirante->getCorreo().'</br>';

        if($aspirante->getIdAspirante() != ''){//Ya aspiró al curso de profundizacion y fue estudiante como 1 y 2*/) {
            //retornar el mensaje de que ya hasido aspirante a este curso.

            return array(0=>false, 1=>'Ya se encuentra registrado un aspirante con el correo ingresado');

        }

        $aspirante->obtenerAspirante('numeroDocumento', $numeroDocumento);

        if($aspirante->getIdAspirante() != ''){//Ya aspiró al curso de profundizacion y fue estudiante como 1 y 2*/) {
            //retornar el mensaje de que ya hasido aspirante a este curso.

            return array(0=>false, 1=>'Ya se encuentra registrado un aspirante con el número de documento ingresado');

        }

        //Registrar al aspirante.
        $contrasenia = md5($contrasenia);
        $aspirante->crearAspirante($correo, $contrasenia, $nombres, $apellidos,
            $tipoDocumento, $numeroDocumento, $fechaNacimiento, $direccionResidencia,
            $telefonoResidencia, $telefonoMovil, $codigo, $promedioPonderado,
            $semestreTerminacionMaterias, $reciboTerminacionMaterias, $reciboPazSalvo,
            $reciboPagoInscripcion);

        $aspirante->obtenerAspirante('codigo', $codigo);
        $this->insertarAspiranteCurso($aspirante->getIdAspirante());
        //Retornar mensaje de éxito.
        return array(0=>true, 1=>CU_EXITO);




    //Estado en 1 Si soy estudiante
            //Si termine el curso 2
            //En 0 cuando queda pendiente... Cuando puede cargar y nunca lo aceptaron o nunca cargo.
            //Aspirar a un curso en un solo lapso de tiempo, no puede aspirar sino hasta que el curso halla pasado



    }


    private function insertarAspiranteCurso($idAspirante){

        echo 'soy id aspirante: '.$idAspirante;
        $fecha = date('Y-m-d');
        $this->peticion = "
                    INSERT INTO AspiranteCurso (idCurso, idAspirante, fecha) VALUES ('$this->idCurso', '$idAspirante', '$fecha')
                    ";

        $this->ejecutar_peticion_simple();

        $this->errores();

    }
























    private function insertar(){

        $this->peticion = "
                    INSERT INTO Curso (nombre, fechaInicio, fechaFin, resolucion) VALUES ('$this->nombre', '$this->fechaInicio',
                    '$this->fechaFin', '$this->resolucion')
                    ";

        $this->ejecutar_peticion_simple();

        $this->errores();
    }


    /**
     * @param $nombreAtributo
     * @param unknown $valor
     */
    private function actualizar($nombreAtributo, $valor) {
        $this->$nombreAtributo = $valor;
        $this->peticion = "
					UPDATE Curso SET " . $nombreAtributo . " = '$valor'
					WHERE Curso.idCurso = '$this->idCurso'
					";
        $this->ejecutar_peticion_simple();
        //Quitar al pasar a Master
        $this->errores();
    }

    /**
     * @param string $correo
     */
    public function obtenerCurso($idCurso = '') {

        if($idCurso != '') {
            $this->peticion = "
						SELECT Curso.*
						FROM Curso
						WHERE Curso.idCurso = '$idCurso'
                        ";
            $this->obtener_resultados_consulta();
            //Quitar al pasar a Master
            $this->errores();
        }

        if(count($this->filas) == 1) {
            $este = 'this';
            foreach ($this->filas[0] as $atributo=>$valor) {
                $$este->$atributo = $valor;
            }
        }else {
            $this->inicializar();
        }

    }


    public function matricularEstudiante($codigoEstudiante){

        $estudiante = new Estudiante();

        $estudiante->obtenerEstudiante($codigoEstudiante);
        $estudiante->setEstado(1);

    }

    public function consultarEstudiantes(){

        $this->peticion = "
						SELECT Usuario.* FROM Usuario, Aspirante, Estudiante, Curso, AspiranteCurso
                        WHERE Usuario.idUsuario = Aspirante.idUsuario AND Aspirante.idAspirante = Estudiante.idAspirante AND
                        Estudiante.estado = 1 AND
                        Curso.idCurso = '$this->idCurso' AND Curso.idCurso = AspiranteCurso.idCurso AND Aspirante.idAspirante = AspiranteCurso.idAspirante
                        ";

        $this->obtener_resultados_consulta();

        return $this->filas;

    }

    public function cargarNotaEstudiante($codigoEstudiante, $nota){

        $estudiante = new Estudiante();
        $estudiante->obtenerEstudiante();

        if($estudiante->getIdEstudiante() != ''){

            $estudiante = new Estudiante();

        }


    }


    /**
     *
     */
    public function consultarNotasEstudiante($idEstudiante){

        $grupo = new GrupoEstudiante();

        return $grupo->obtenerNotasGrupoEstudiante($idEstudiante);

    }


    /**
     *
     */






















































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































} 