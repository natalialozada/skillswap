<?php
require_once __DIR__ . '/models/guardar-perfil-model.php';
require_once __DIR__ . '/models/login-model.php';
require_once __DIR__ . '/models/conexion-model.php';
require_once __DIR__ . '/Db/Con1DB.php';

session_start();

if (!isset($_GET['id'])) {
    echo "ID no proporcionado";
    exit;
}

$idPerfil = intval($_GET['id']); // ID del perfil que estamos viendo

$modelo = new PerfilModel();
$perfil = $modelo->getData("SELECT * FROM perfiles WHERE id_usu = ?", "i", $idPerfil);

if (!$perfil) {
    echo "Perfil no encontrado";
    exit;
}

// Traer info básica del dueño del perfil
$login = new login();
$usuario = $login->getData("SELECT nombre, tel FROM usuarios WHERE id_usu = ?", "i", $idPerfil);
$nombreUsuario = $usuario['nombre'] ?? 'Usuario';
$telefonoUsuario = $usuario['tel'] ?? null;

// Obtener ID del usuario actual desde la sesión
$nombreActual = $_SESSION['usuario'] ?? null;
$idActual = null;
$mostrarTelefono = false;

if ($nombreActual) {
    $actual = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreActual);
    $idActual = $actual['id_usu'] ?? null;

    // Verificar conexión aceptada entre ambos
    if ($idActual && $idActual !== $idPerfil) {
        $conexionModel = new ConexionModel();
        $conexion = $conexionModel->getData(
            "SELECT * FROM conexiones 
             WHERE estado = 'aceptado' AND 
             ((id_remitente = ? AND id_destino = ?) OR (id_remitente = ? AND id_destino = ?))",
            "iiii",
            $idActual, $idPerfil,
            $idPerfil, $idActual
        );

        $mostrarTelefono = $conexion ? true : false;
    }
}

require_once "views/ver-perfil-view.php";
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
