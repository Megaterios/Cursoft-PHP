<?php

session_start();

require_once 'application/controller/SistemaCursoProfundizacion.php';

$aplicacion = new SistemaCursoProfundizacion();

$aplicacion->cerrarSesion();

if(isset($_POST['requerimiento']) ) {
    switch ($_POST['requerimiento']) {

        case 'RF1_INICIAR_SESION':
            $aplicacion->iniciarSesion($_POST['correo'], $_POST['contrasenia'], $_POST['tipo']);
            break;

        case 'RF2_FINALIZAR_SESION':
            $aplicacion->cerrarSesion();
            break;

        case 'RF3_RECUPERAR_CONTRASENIA':
            $aplicacion->recuperarContrasenia($_POST['correo']);
            break;

        case 'RF4_CONSULTAR_DATOS':
            break;

        case 'RF5_ACTUALIZAR_DATOS':
            break;

        case 'RF6_ELIMINAR_ESTUDIANTE':
            break;

        case 'RF7-RF8-RF9_CAMBIAR_ESTADO':
            break;

        case 'RF10_REGISTRAR_ASPIRANTE':
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








































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































?>