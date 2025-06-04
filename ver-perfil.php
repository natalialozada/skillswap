<?php
require_once __DIR__ . '/models/guardar-perfil-model.php';
require_once __DIR__ . '/models/login-model.php';
require_once __DIR__ . '/Db/Con1DB.php';
session_start();

if (!isset($_GET['id'])) {
    echo "ID no proporcionado";
    exit;
}

$idPerfil = intval($_GET['id']);
$modelo = new PerfilModel();
$perfil = $modelo->getData("SELECT * FROM perfiles WHERE id_usu = ?", "i", $idPerfil);

if (!$perfil) {
    echo "Perfil no encontrado";
    exit;
}

$login = new login();
$usuario = $login->getData("SELECT nombre FROM usuarios WHERE id_usu = ?", "i", $idPerfil);
$nombreUsuario = $usuario['nombre'] ?? 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Ver perfil | SkillSwap</title>
  <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <?php require_once "views/ver-perfil-view.php"; ?>
</body>
</html>
