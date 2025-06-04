<?php
require_once "../models/solicitud-model.php";

$idConexion = $_POST['id_conexion'];
$accion = $_POST['accion'];

if (in_array($accion, ['aceptado', 'rechazado'])) {
    $modelo = new SolicitudModel();
    $modelo->responderSolicitud($idConexion, $accion);
}

header("Location: ../notificaciones.php");
exit;
