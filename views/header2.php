<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/login-model.php';
$login = new login();
$nombreUsuario = $_SESSION['usuario'];
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreUsuario);
$idUsuario = $result['id_usu'] ?? null;
?>

<header class="header">
  <div class="logo">
    <img class="logo-img" src="assets/img/logo-sin-fondo.png" alt="SkillSwap Logo" />
    <img class="logo-texto" src="assets/img/nombre-skill-swap.png" alt="SkillSwap nombre" />
  </div>
  <nav class="nav">
  <a href="mi-perfil.php" class="nav-link">Mi perfil</a>
    <a href="views/cerrar-sesion.php" class="nav-link btn-registrar">Cerrar Sesión</a>
  </nav>
</header>
