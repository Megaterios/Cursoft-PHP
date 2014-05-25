<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:23 AM
 */



class Docente {


    private $idDocente;
    private $idUsuario;
    private $escolaridad;
    private $escalafon;
    private $puntaje;


    function __construct(){

    }

    function crear($escolaridad, $escalafon, $puntaje){

        $this->escolaridad = $escolaridad;
        $this->escalafon = $escalafon;
        $this->puntaje = $puntaje;

    }

    /**
     *
     */
    public function inicializar(){

        $this->idUsuario = '';
        $this->idUsuario = '';
        $this->escolaridad = '';
        $this->escalafon = '';
        $this->puntaje = '';

    }


    /**
     * @return mixed
     */
    public function getIdDocente(){

        return $this->idDocente;

    }

    /**
     * @return mixed
     */
    public function getIdUsuario(){

        return $this->idUsuario;

    }


    /**
     * @param mixed $nombre
     */
    public function setEscolaridad($escolaridad){

        $this->escolaridad = $escolaridad;
        $this->actualizar('escolaridad', $this->escolaridad);

    }

    /**
     * @return mixed
     */
    public function getEscolaridad(){

        return $this->escolaridad;

    }


    /**
     * @param mixed $nombre
     */
    public function setEscalafon($escalafon){

        $this->escalafon = $escalafon;
        $this->actualizar('escalafon', $this->escalafon);

    }


    /**
     *
     */
    public function getEscalafon(){

        return $this->escalafon;

    }


    /**
     * @param mixed $nombre
     */
    public function setPuntaje($puntaje){

        $this->puntaje = $puntaje;
        $this->actualizar('puntaje', $this->puntaje);

    }

    /**
     *
     */
    public function getPuntaje(){

        return $this->puntaje;

    }


    /**
     * @param $nombreAtributo
     * @param unknown $valor
     */
    private function actualizar($nombreAtributo, $valor) {

        $this->$nombreAtributo = $valor;
        $this->peticion = "
					UPDATE Docente SET " . $nombreAtributo . " = '$valor'
					WHERE Docente.idDocente = '$this->idDocente'
					";

        $this->ejecutar_peticion_simple();
        //Quitar al pasar a Master
        $this->errores();
    }

    /**
     * @param string $correo
     */
    public function obtenerDocente($codigo = '') {

        if($codigo != '') {
            $this->peticion = "
						SELECT Docente.*
						FROM Docente, Usuario
						WHERE Usuario.codigo = '$codigo' AND Usuario.idUsuario = Docente.idUsuario";

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