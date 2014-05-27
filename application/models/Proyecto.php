<?php
/**
 * Created by PhpStorm.
 * User: Jhorman
 * Date: 23/05/14
 * Time: 20:21
 */

class Proyecto {



    private $idProyecto;
    private $nombreProyecto;
    private $notaProyecto;
    private $idEstudiante;
    private $documentoProyecto;


    function __construct(){

    }

    function crear($idProyecto, $nombreProyecto, $notaProyecto){

        $this->idProyecto = $idProyecto;
        $this->nombreProyecto = $nombreProyecto;
        $this->notaProyecto = $notaProyecto;

    }


    /**
     *
     */
    public function inicializar(){

        $this->idProyecto = '';
        $this->nombreProyecto = '';
        $this->notaProyecto = '';

    }

    /**
     * @param mixed $nombreProyecto
     */
    public function setNombreProyecto($nombreProyecto){

        $this->nombreProyecto = $nombreProyecto;
        $this->actualizar('nombreProyecto', $this->nombreProyecto);

    }

    /**
     * @return mixed
     */
    public function getNombreProyecto(){

        return $this->nombreProyecto;

    }


    /**
     * @param mixed $notaProyecto
     */
    public function setNotaProyecto($notaProyecto){

        $this->notaProyecto = $notaProyecto;
        $this->actualizar('notaProyecto', $this->notaProyecto);

    }


    /**
     * @param mixed $notaProyecto
     */
    public function getNotaProyecto(){

        return $this->notaProyecto;

    }

    /**
     * @param $documentoProyecto
     */
    public function setDocumentoProyecto($documentoProyecto){

        $this->documentoProyecto = $documentoProyecto;
        $this->actualizar('documentoProyecto', $this->documentoProyecto);

    }

    /**
     * @return mixed
     */
    public function getDocumentoProyecto(){

        return $this->documentoProyecto;

    }

    /**
     * @return mixed
     */
    public function getIdProyecto()
    {
        return $this->idProyecto;
    }

    /**
     * @param $nombreAtributo
     * @param unknown $valor
     */
    private function actualizar($nombreAtributo, $valor) {

        $this->$nombreAtributo = $valor;
        $this->peticion = "
					UPDATE Proyecto SET " . $nombreAtributo . " = '$valor'
					WHERE Proyecto.idProyecto = '$this->idProyecto'
					";

        $this->ejecutar_peticion_simple();
        //Quitar al pasar a Master
        $this->errores();
    }

    /**
     * @param string $correo
     */
    public function obtenerProyecto($idProyecto = '') {

        if($idProyecto != '') {
            $this->peticion = "
						SELECT Proyecto.*
						FROM Proyecto
						WHERE Proyecto.idProyecto = '$idProyecto'";

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

    public function obtenerProyectos(){

         $this->peticion = "
					SELECT Proyecto.*
					FROM Proyecto
					WHERE Proyecto.idProyecto = '$idProyecto'";

         $this->obtener_resultados_consulta();
         //Quitar al pasar a Master
         $this->errores();

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