<?php

/**
 *  Requerimos el archivo config.php, que contiene las constantes generales en la aplicación web y otras configuraciones.
 */
require_once '/../config/bdDevelopment.php';

/**
 * Clase de abstracción, contiene funciones que acceden a la base de datos.
 * 
 * La clase abstracta modelo_bd es la encargada de acceder directamente a la base de datos 
 * y manejar todo lo referente a esta. 
 * 
 * @author yeisonvargasf
 * 
 */
abstract class baseDatos {
	
	#Atributos
	private static $bd_host = BD_HOST;
	private static $bd_usuario = BD_USUARIO;
	private static $bd_contrasena = BD_CONTRASENA;
	private static $bd_nombre = BD_NOMBRE;
	protected $peticion;
	protected $filas =array();
	protected $conexion;
	protected $mensaje;
	protected $codigo_error;
	
	
	/**
	 *  Función encargada de crear una conexión con la base de datos.
	 *  
	 *  Crea una nueva instancia de la clase PDO enviando como parámetros en el
	 *  constructor el nombre del host, el nombre de la base de datos, el nombre
	 *  del usuario y la contraseña. En el caso de que exista algún error en el
	 *  proceso, se captura y se almacena la información del mensaje del error 
	 *  y el código de éste. 
	 *  
	 */
	private function crear_conexion() {
		try {
			$this->conexion = new PDO('mysql:host='.self::$bd_host.';dbname='.self::$bd_nombre, self::$bd_usuario, self::$bd_contrasena);	
		}catch (PDOException $excepcion) {
			$this->mensaje = BD_ERROR_CONEXION.$excepcion->getMessage();
			$this->codigo_error = BD_ERROR_CONEXION.$excepcion->getCode();	
		}
		
	}
	
	/**
	 * Función encargada de borrar una conexión con la base de datos. 
	 * 
	 * Borra la instancia actual de la clase PDO igualandola a null, esta instancia
	 * tiene la conexión actual con la base de datos, de esta manera la conexión
	 * es borrada.
	 * 
	 */
	private function borrar_conexion() {
		$this->conexion = null;		
	}
	
	/**
	 * Función encargada de ejecutar una peticion sql simple (INSERT, DELETE, UPDATE) en la base de datos.
	 * 
	 * Crea la conexión con la base de datos llamando al respectivo método, prepara la petición sql llamando
	 * al método prepare de la instancia 'conexion' de la clase PDO y luego la ejecuta, guarda información
	 * de posibles errores producidos al realizar la petición y luego borra la conexión.
	 * 
	 */
	protected function ejecutar_peticion_simple() {
		$this->crear_conexion();
		$temporal = $this->conexion->prepare($this->peticion);
		$temporal->execute();
		$this->mensaje = $temporal->errorInfo();
		$this->codigo_error = $temporal->errorCode();		
		$this->borrar_conexion();
	}
	
	/**
	 * Función encargada de ejecutar consultas sql en la base de datos.
	 * 
	 * Crea la conexión con la base de datos llamando al respectivo método, prepara la petición sql llamando
	 * al método prepare de la instancia 'conexion' de la clase PDO y luego la ejecuta, guarda información
	 * de posibles errores producidos al realizar la petición y convierte los resultados de la consulta en 
	 * un array asociativo que se trasnfiere al atributo filas y luego borra la conexión.
	 * 
	 */
	protected function obtener_resultados_consulta() { 
		$this->crear_conexion();
		$temporal = $this->conexion->prepare($this->peticion);
		$temporal->execute();
		$this->mensaje = $temporal->errorInfo();
		$this->codigo_error = $temporal->errorCode();
		while($this->filas[] =  $temporal->fetch(PDO::FETCH_ASSOC) );
		array_pop($this->filas);
		$this->borrar_conexion();
	}

    protected function errores() {
        print_r($this->mensaje);
        echo $this->codigo_error;
    }
	
	
}

?>
