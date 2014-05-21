<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:16 AM
 */

require_once '/../libs/baseDatos.php';

class Usuario {

    use baseDatos;

    private $cedula;
    private $nombre;
    private $apellido;
    private $correo;
    private $contrasenia;
    private $fechaNacimiento;
    private $telefonoFijo;
    private $telefonoCelular;
    private $direccion;

    function __construct()
    {
    }

    function crear($apellido, $cedula, $contrasenia, $correo, $direccion, $fechaNacimiento, $nombre, $telefonoCelular, $telefonoFijo)
    {
        $this->apellido = $apellido;
        $this->cedula = $cedula;
        $this->contrasenia = $contrasenia;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->nombre = $nombre;
        $this->telefonoCelular = $telefonoCelular;
        $this->telefonoFijo = $telefonoFijo;
    }

    public function inicializar() {
        $this->apellido = '';
        $this->cedula = '';
        $this->contrasenia = '';
        $this->correo = '';
        $this->direccion = '';
        $this->fechaNacimiento = '';
        $this->nombre = '';
        $this->telefonoCelular = '';
        $this->telefonoFijo = '';
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
        $this->actualizar('apellido', $this->getApellido());
    }

    /**
     * @return mixed
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $cedula
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
        $this->actualizar('cedula', $this->getCedula());
    }

    /**
     * @return mixed
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * @param mixed $contrasenia
     */
    public function setContrasenia($contrasenia)
    {
        $this->contrasenia = $contrasenia;
        $this->actualizar('contrasenia', $this->getContrasenia());
    }

    /**
     * @return mixed
     */
    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
        $this->actualizar('correo', $this->getCorreo());
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        $this->actualizar('direccion', $this->getDireccion());
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
        $this->actualizar('fechaNacimiento', $this->getFechaNacimiento());
    }

    /**
     * @return mixed
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->actualizar('nombre', $this->getNombre());
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $telefonoCelular
     */
    public function setTelefonoCelular($telefonoCelular)
    {
        $this->telefonoCelular = $telefonoCelular;
        $this->actualizar('telefonoCelular', $this->getTelefonoCelular());
    }

    /**
     * @return mixed
     */
    public function getTelefonoCelular()
    {
        return $this->telefonoCelular;
    }

    /**
     * @param mixed $telefonoFijo
     */
    public function setTelefonoFijo($telefonoFijo)
    {
        $this->telefonoFijo = $telefonoFijo;
        $this->actualizar('telefonoFijo', $this->getTelefonoFijo());
    }

    /**
     * @return mixed
     */
    public function getTelefonoFijo()
    {
        return $this->telefonoFijo;
    }

    /**
     *
     * @param string $correo
     */
    public function obtener($correo='') {

        if($correo != '') {
            $this->peticion = "
						SELECT *
						FROM Usuario
						WHERE correo = '$correo'";
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


    /**
     * Método que permite actualizar los datos de un usuario.
     * @param unknown $nombre_atributo: Indica el atributo que desea modificarse.
     * @param unknown $valor: Indica el nuevo valor que se dará al atributo especificado.
     */
    private function actualizar($nombreAtributo, $valor) {
        $this->$nombreAtributo = $valor;
        $this->peticion = "
					UPDATE Usuario SET " . $nombreAtributo . " = '$valor'
					WHERE correo = '$this->correo'
					";
        $this->ejecutar_peticion_simple();
        //Quitar al pasar a Master
        $this->errores();
    }

    public function __toString()
    {
        return  "<br>".$this->cedula."<br>".$this->nombre."<br>".$this->apellido."<br>".$this->correo."<br>".$this->contrasenia."<br>".
                $this->fechaNacimiento."<br>".$this->direccion;
    }

    public function obtenerDatos($correo) {

        if($correo != '') {
            $this->peticion = "
                        SELECT *
						FROM Usuario
						INNER JOIN $tipo
						WHERE Usuario.correo = '$correo' AND Usuario.idUsuario = $tipo.idUsuario ";
            $this->obtener_resultados_consulta();
            //Quitar al pasar a Master
            $this->errores();
        }

        echo "<br>";
        print_r( $this->filas);

/*
        if(count($this->filas) == 1) {
            $este = 'this';
            foreach ($this->filas[0] as $atributo=>$valor) {
                $$este->$atributo = $valor;
            }
        }else {
            $this->inicializar();
        }
*/
    }



}