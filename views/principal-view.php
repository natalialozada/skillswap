<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../models/login-model.php';
require_once __DIR__ . '/../models/guardar-perfil-model.php';
require_once __DIR__ . '/../models/conexion-model.php';

$nombreUsuario = $_SESSION['usuario'];
$login = new login();
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreUsuario);
$idUsuario = $result['id_usu'] ?? null;

$mostrarModal = false;
$usuarios = [];
$alertas = [];

if ($idUsuario) {
    $perfilModel = new PerfilModel();
    $conexionModel = new ConexionModel();

    $perfil = $perfilModel->getData("SELECT * FROM perfiles WHERE id_usu = ?", "i", $idUsuario);

    if (!$perfil) {
        $mostrarModal = true;
    } else {
        $usuarios = $perfilModel->getAllUsersExcept($idUsuario);

        // 🔔 Cargar alertas no leídas
        $alertas = $conexionModel->getAll("SELECT * FROM alertas WHERE id_usuario = ? AND leido = 0", "i", $idUsuario);
    }
}
?>

<?php if ($mostrarModal): ?>
<div id="modalPerfil" class="modal">
  <div class="modal-contenido modal-contenido--miPerfil">
    <div class="encabezado-modal">
      <h2>¡Bienvenido! Primero crea tu perfil</h2>
    </div>
    <form id="form-perfil" enctype="multipart/form-data" method="post">
      <div class="lado-izquierdo">
        <img src="assets/img/avatar-default.png" class="foto-perfil-preview" />
        <div class="input-file-personalizado">
          <label for="foto_perfil" class="custom-file-label">Subir foto</label>
          <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*" required />
        </div>
        <input type="text" name="nombre" placeholder="Nombre" required />
        <input type="text" name="ciudad" placeholder="Ciudad, País" required />
        <input type="text" name="dias_disponibles" placeholder="Días disponibles" required />
        <input type="text" name="telefono" placeholder="Número de teléfono" required />
      </div>

      <div class="lado-derecho">
        <label>Sobre mí</label>
        <textarea name="sobre_mi" placeholder="Cuéntanos brevemente sobre ti" required></textarea>

        <label>Habilidades que puedo enseñar</label>
        <textarea name="habilidades_ensenar" placeholder="Por ejemplo: piano, guitarra..." required></textarea>

        <label>Habilidades que quiero aprender</label>
        <textarea name="habilidades_aprender" placeholder="Por ejemplo: patinar, programar..." required></textarea>

        <button type="submit" class="btn-primario">Guardar Perfil</button>
      </div>
    </form>
  </div>
</div>
<?php else: ?>


<!-- ✅ Mostrar alertas -->
<?php foreach ($alertas as $alerta): ?>
  <div class='alerta'><?php echo htmlspecialchars($alerta['mensaje']); ?></div>
  <?php
    // Marcar como leída
    $conexionModel->actualizarDato("UPDATE alertas SET leido = 1 WHERE id = ?", "i", $alerta['id']);
  ?>
<?php endforeach; ?>

<!-- Página principal -->
<div class="contenedor-bienvenida">
  <div class="fila-bienvenida">
    <h1 class="titulo-centrado">
      ¡HOLA, <span class="purple"><?php echo strtoupper($_SESSION['usuario']); ?></span>!
    </h1>
    <div class="campana-notificaciones">
      <img src="assets/img/campana.png" alt="Notificaciones" id="campana-icono" />
      <span id="contador-notis" class="contador" style="display:none;">0</span>
    </div>
  </div>
  <p>Explora y empieza a conectar con más usuarios...</p>
</div>



<div class="contenedor-usuarios">
  <?php foreach ($usuarios as $usu): ?>
    <div class="card-usuario">
      <img class="avatar" src="<?php echo $usu['foto_perfil']; ?>" alt="Foto de <?php echo $usu['nombre']; ?>">
      <h3><?php echo strtoupper($usu['nombre']); ?></h3>
      <p><strong>Quiere Aprender:</strong><br><?php echo nl2br($usu['habilidades_aprender']); ?></p>
      <p><strong>Puede Enseñarte:</strong><br><?php echo nl2br($usu['habilidades_ensenar']); ?></p>
      <a href="ver-perfil.php?id=<?php echo $usu['id_usu']; ?>" class="btn-primario">Ver perfil</a>
      <button class="btn-primario btn-conectar" data-id="<?php echo $usu['id_usu']; ?>">Conectar</button>
    </div>
  <?php endforeach; ?>
</div>

<?php endif; ?>
