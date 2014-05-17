<?php
/**
 * Created by PhpStorm.
 * User: YeisonVargas
 * Date: 16/05/14
 * Time: 10:16 AM
 */


namespace application\models;

require_once '../libs/baseDatos.php';

class Usuario extends baseDatos {

    private $cedula;
    private $nombre;
    private $apellido;
    private $correo;
    private $contraseña;
    private $fechaNacimiento;
    private $telefonoFijo;
    private $telefonoCelular;
    private $direccion;

    function __construct($apellido, $cedula, $contraseña, $correo, $direccion, $fechaNacimiento, $nombre, $telefonoCelular, $telefonoFijo)
    {
        $this->apellido = $apellido;
        $this->cedula = $cedula;
        $this->contraseña = $contraseña;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->nombre = $nombre;
        $this->telefonoCelular = $telefonoCelular;
        $this->telefonoFijo = $telefonoFijo;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
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
    }

    /**
     * @return mixed
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * @param mixed $contraseña
     */
    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;
    }

    /**
     * @return mixed
     */
    public function getContraseña()
    {
        return $this->contraseña;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
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
    }

    /**
     * @return mixed
     */
    public function getTelefonoFijo()
    {
        return $this->telefonoFijo;
    }




}