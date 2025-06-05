<?php/*
session_start();
require_once "../models/login-model.php";
require_once "../models/solicitud-model.php";

$login = new login();
$perfil = new SolicitudModel();

$idEmisor = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $_SESSION['usuario'])['id_usu'];
$idReceptor = $_POST['id_receptor'];

if ($idEmisor && $idReceptor && $idEmisor !== $idReceptor) {
    $perfil->crearSolicitud($idEmisor, $idReceptor);
}

header("Location: ../principal.php");
exit;
