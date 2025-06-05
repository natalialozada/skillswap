<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/models/login-model.php';
require_once __DIR__ . '/models/conexion-model.php';
$login = new login();
$modelo = new ConexionModel();

$nombreUsuario = $_SESSION['usuario'];
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreUsuario);
$idUsuario = $result['id_usu'] ?? null;

$solicitudesRecibidas = $modelo->getAll(
    "SELECT c.*, u.nombre 
     FROM conexiones c 
     JOIN usuarios u ON c.id_remitente = u.id_usu 
     WHERE c.id_destino = ?", "i", $idUsuario
);

$solicitudesEnviadas = $modelo->getAll(
    "SELECT c.*, u.nombre, u.tel AS tel_destino
     FROM conexiones c 
     JOIN usuarios u ON c.id_destino = u.id_usu 
     WHERE c.id_remitente = ?", "i", $idUsuario
);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NOTIFICACIONES | SKILL SWAP</title>
    <link rel="stylesheet" href="style/main.css">
    <script src="assets/js/app.js" defer></script>
</head>
<body>
    <?php require_once "views/header3.php"; ?>
    <?php require_once "views/notificaciones-view.php"; ?>
</body>
</html>
