<?php

if(!session_id()) session_start();

require_once 'application/controller/SistemaCursoProfundizacion.php';

$aplicacion = new SistemaCursoProfundizacion();

//$aplicacion->cerrarSesion();

if(isset($_POST['requerimiento']) ) {
    switch ($_POST['requerimiento']) {

        case 'RF1_INICIAR_SESION':
            $aplicacion->iniciarSesion($_POST['correo'], $_POST['contrasenia'], $_POST['tipo']);
            break;

        case 'RF3_RECUPERAR_CONTRASENIA':
            $aplicacion->recuperarContrasenia($_POST['correo']);
            break;

        case 'RF4_CONSULTAR_DATOS':
            $aplicacion->consultarDatos();
            break;

        case 'RF5_ACTUALIZAR_DATOS':
            $aplicacion->actualizarDatos();
            break;

        case 'RF6_ELIMINAR_ESTUDIANTE':
            break;

        case 'RF7-RF8-RF9_CAMBIAR_ESTADO':
            break;

        case 'RF10_REGISTRAR_ASPIRANTE':

            $idCurso = 1;
            $reciboPazSalvo = 'pazSalvo.jpg';
            $reciboTerminacionMaterias = 'reciboTerminacion.jpg';
            $reciboPagoInscripcion = 'reciboPago.jpg';
            $tipoUsuario = 1;


            $aplicacion->registrarAspirante($_POST['correo'], $_POST['contrasenia'], $_POST['confirmacionContrasenia'],
                $_POST['nombres'], $_POST['apellidos'], $_POST['tipoDocumento'], $_POST['numeroDocumento'],
                $_POST['fechaNacimiento'], $_POST['direccionResidencia'], $_POST['telefonoResidencia'], $_POST['telefonoMovil'],
                $_POST['codigo'], $_POST['promedioPonderado'], $_POST['semestreTerminacionMaterias'],
                $reciboTerminacionMaterias, $reciboPazSalvo,  $reciboPagoInscripcion,
                $idCurso, $tipoUsuario);

            break;

        case 'RF11-RF12_CARGAR_DOCUMENTOS':
            break;

        case 'RF13_REGISTRAR_DOCENTE':
            break;

        case 'R14_REGISTRAR_COORDINADOR':
            break;

        case 'R15_ELIMINAR_COORDINADOR':
            break;

        case 'R16_':
            break;

        case 'R17_':
            break;

        case 'R15_':
            break;

    }
}else if(isset($_GET['requerimiento'])) {

    switch($_GET['requerimiento']) {

        case 'RF2_FINALIZAR_SESION':
            $aplicacion->cerrarSesion();
            $aplicacion->cargarVista();
            break;
    }

}else {
    $mostrar = '';

    if(isset($_GET['mostrar'])) {

        $mostrar =  $_GET['mostrar'];
    }

    $aplicacion->cargarVista($mostrar);


}

//$aplicacion->enviarCorreo('yei558@gmail.com', 'Correo Cursoft', 'Hola esta es la prueba de correo de cursoft');

//$aplicacion->enviarCorreo('abdul.laiseca@gmail.com', 'Correo Cursoft', 'Hola esta es la prueba de correo de cursoft');

//$aplicacion->enviarCorreo('jhorapb@gmail.com', 'Correo Cursoft', 'Hola esta es la prueba de correo de cursoft');

//$aplicacion->recuperarContraseña('yei558@gmail.com');

  //  $aplicacion->consultarDatos();


/*



    //$aplicacion->consultarNotasCursoEstudiante(1, 15);

































































*/































































































































































































































































































































































































































































































































































































































































































































































































































































































































































?>