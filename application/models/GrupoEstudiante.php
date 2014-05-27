<?php
/**
 * Created by PhpStorm.
 * User: Jhorman
 * Date: 21/05/14
 * Time: 12:47
 */

require_once ('Estudiante.php');
require_once ('application/libs/baseDatos.php');


class GrupoEstudiante extends baseDatos{


    private $idDocenteModuloEstudiante;
    private $idEstudiante;
    private $idDocente;


    function __construct(){

    }

    function crear($idEstudiante, $idDocente){

        $this->idEstudiante = $idEstudiante;
        $this->idDocente = $idDocente;
    }


    /**
     *
     */
    public function inicializar(){

        $this->idDocenteModuloEstudiante = '';
        $this->idEstudiante = '';
        $this->idDocente = '';

    }

    /**
     *
     */
    private function insertar(){

        $this->peticion = "
                    INSERT INTO DocenteModuloEstudiante (idEstudiante, idDocente) VALUES ('$this->idEstudiante', '$this->idDocente')
                    ";

        $this->ejecutar_peticion_simple();

        $this->errores();
    }


    /**
     * @param $nombreAtributo
     * @param unknown $valor
     */
    private function actualizarGrupoEstudiante($nombreAtributo, $valor) {

        $this->$nombreAtributo = $valor;
        $this->peticion = "
					UPDATE DocenteModuloEstudiante SET " . $nombreAtributo . " = '$valor'
					WHERE DocenteModuloEstudiante.idDocenteModuloEstudiante = '$this->idDocenteModuloEstudiante'
					";
        $this->ejecutar_peticion_simple();
        //Quitar al pasar a Master
        $this->errores();

    }

    /**
     * @param string $correo
     */
    public function obtenerGrupoEstudiante($codigoEstudiante, $codigoDocente) {

        $estudiante = new Estudiante();
        $estudiante->obtenerEstudiante($codigoEstudiante);

        $docente = new Docente();
        $docente->obtenerDocente($codigoDocente);

        if($estudiante->getIdEstudiante() != '' && $docente->getIdDocente() != '') {

            $this->peticion = "
						SELECT DocenteModuloEstudiante.*
						FROM DocenteModuloEstudiante
						WHERE DocenteModuloEstudiante.idEstudiante = '$estudiante->getIdEstudiante()' AND
						DocenteModuloEstudiante.idDocente = '$docente->getIdDocente()'
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



    public function obtenerNotasGrupoEstudiante($idEstudiante) {

        /*
        $estudiante = new Estudiante();
        $estudiante->obtenerEstudiante($codigoEstudiante);
        */

        if($idEstudiante != '') {

            $this->peticion = "
						SELECT Modulo.idModulo, Modulo.nombre, Usuario.nombre, Usuario.apellido, DocenteModuloEstudiante.nota
                        FROM Modulo, Docente, DocenteModuloEstudiante, DocenteModulo, Estudiante, Usuario
                        WHERE Modulo.idModulo = DocenteModulo.idModulo AND
                        DocenteModulo.idDocenteModulo = DocenteModuloEstudiante.idDocenteModulo AND
                        Estudiante.idEstudiante= '$idEstudiante' AND Estudiante.idEstudiante = DocenteModuloEstudiante.idEstudiante
                        AND Usuario.idUsuario = Docente.idUsuario AND Docente.idDocente = DocenteModulo.idDocente AND
                        DocenteModulo.idDocenteModulo = DocenteModuloEstudiante.idDocenteModulo
                        ";

            $this->obtener_resultados_consulta();
            //Quitar al pasar a Master
            $this->errores();
        }

        return $this->filas;

    }

}



?>