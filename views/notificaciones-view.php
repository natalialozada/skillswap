<?php
require_once __DIR__ . '/../models/login-model.php';
require_once __DIR__ . '/../models/solicitud-model.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$login = new login();
$solicitudes = new SolicitudModel();

$usuario = $_SESSION['usuario'] ?? null;

$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $usuario);
$idUsuario = $result['id_usu'] ?? null;

$recibidas = $solicitudes->obtenerSolicitudesRecibidas($idUsuario);
$enviadas = $solicitudes->obtenerSolicitudesEnviadas($idUsuario);
?>

<div class="notificaciones-wrapper">
  <header class="header">
    <div class="logo">
      <img src="assets/img/logo-sin-fondo.png" alt="logo" class="logo-img">
      <img src="assets/img/nombre-skill-swap.png" alt="Skill Swap" class="logo-texto">
    </div>
    <nav class="nav">
      <a href="principal.php" class="nav-link">Volver</a>
      <a href="views/cerrar-sesion.php" class="nav-link btn-registrar">Cerrar Sesión</a>
    </nav>
  </header>

  <h2 class="titulo-notificaciones">NOTIFICACIONES</h2>

  <div class="notificaciones-contenedor">
    <div class="columnas">
      <div class="columna">SOLICITUDES</div>
      <div class="columna">ENVIADAS</div>
    </div>
    <div class="contenidos">
      <!-- Recibidas -->
      <div class="notificaciones-recibidas">
        <?php foreach ($recibidas as $sol): ?>
          <div class="notificacion">
            <span><strong><?php echo $sol['nombre']; ?></strong> quiere conectar</span>
            <a href="ver-perfil.php?id=<?php echo $sol['id_usu']; ?>" class="btn-mini">Ver Perfil</a>
            <form action="controllers/responder-solicitud-controller.php" method="post">
              <input type="hidden" name="id_conexion" value="<?php echo $sol['id_conexion']; ?>">
              <button type="submit" name="accion" value="aceptado" class="btn-mini">✔</button>
              <button type="submit" name="accion" value="rechazado" class="btn-mini">✖</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Enviadas -->
      <div class="notificaciones-enviadas">
        <?php foreach ($enviadas as $env): ?>
          <div class="notificacion">
            <span>Quieres conectar con <strong><?php echo $env['nombre']; ?></strong></span>
            <a href="ver-perfil.php?id=<?php echo $env['id_usu']; ?>" class="btn-mini">Ver Perfil</a>
            <span class="estado <?php echo $env['estado']; ?>">
              <?php echo strtoupper($env['estado']); ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <p class="info-aviso">RECUERDA QUE SI ACEPTAN TU SOLICITUD APARECERÁ EL NÚMERO DE TELÉFONO DEL USUARIO EN SU PERFIL</p>
</div>
