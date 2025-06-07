<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/../models/login-model.php';
require_once __DIR__ . '/../models/guardar-perfil-model.php';

$login = new login();
$nombreUsuario = $_SESSION['usuario'];
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreUsuario);
$idUsuario = $result['id_usu'] ?? null;

if (!$idUsuario) {
    echo "Usuario no encontrado.";
    exit;
}

$modelo = new PerfilModel();

// Borrar perfil
$sqlPerfil = "DELETE FROM perfiles WHERE id_usu = ?";
$res1 = $modelo->actualizarDato($sqlPerfil, "i", $idUsuario);

$sqlTel = "UPDATE usuarios SET tel = NULL WHERE id_usu = ?";
$res2 = $modelo->actualizarDato($sqlTel, "i", $idUsuario);

if ($res1['status'] === 'success') {
    header("Location: ../principal.php");
    exit;
} else {
    echo "Error al borrar el perfil.";
}
