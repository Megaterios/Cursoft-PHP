<?php
/**
 * Created by PhpStorm.
 * User: Jhorman
 * Date: 21/05/14
 * Time: 12:47
 */

require_once ('Estudiante.php');
require_once ('application/libs/baseDatos.php');


class GrupoEstudiante {

    use baseDatos;

    private $estudiante;
    private $docente;


    function __construct(){

    }

    function crear($promedioPonderado, $semestreFinalizacionMaterias, $reporteFinalizacionMaterias,
                   $reportePazSalvo, $reciboInscripcion){

        $this->promedioPonderado = $promedioPonderado;
        $this->semestreFinalizacionMaterias = $semestreFinalizacionMaterias;
        $this->reporteFinalizacionMaterias = $reporteFinalizacionMaterias;
        $this->reportePazSalvo = $reportePazSalvo;
        $this->reciboInscripcion = $reciboInscripcion;
        $this->estado = 0;
    }

    /**
     * @param mixed $nombre
     */
    public function setReciboMatricula($reciboMatricula){
        $this->reciboMatricula = $reciboMatricula;
        $this->actualizar('reciboMatricula', $this->reciboMatricula);
    }

    /**
     * @return mixed
     */
    public function getReciboMatricula()
    {
        return $this->reciboMatricula;
    }


    /**
     * @param mixed $nombre
     */
    public function setEstado($estado){
        $this->estado = $estado;
        $this->actualizar('estado', $this->estado);
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }


    private function insertar(){

        $this->peticion = "
                    INSERT INTO Aspirante (promedioPonderado, semestreFinalizacionMaterias, reporteFinalizacionMaterias,
                    reportePazSalvo, reciboInscripcion, estado) VALUES ('$this->promedioPonderado', '$this->semestreFinalizacionMaterias',
                    '$this->reporteFinalizacionMaterias', '$this->reportePazSalvo', '$this->reciboInscripcion', '$this->estado')
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
					UPDATE Aspirante SET " . $nombreAtributo . " = '$valor'
					WHERE Aspirante.idAspirante = '$this->idAspirante'
					";
        $this->ejecutar_peticion_simple();
        //Quitar al pasar a Master
        $this->errores();
    }

    /**
     * @param string $correo
     */
    public function obtenerGrupoEstudiante($estudiante = new Estudiante(), $docente = new Docente()) {

        $estudiante = new Estudiante();

        if($estudiante != '' && $docente != '') {
            $this->peticion = "
						SELECT DocenteModuloEstudiante.*
						FROM DocenteModuloEstudiante, Estudiante, Docente
						WHERE $estudiante.codigo = '$codigo' AND Usuario.idUsuario = Aspirante.idUsuario
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



} 