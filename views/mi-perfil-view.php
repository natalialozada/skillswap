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

$nombreUsuario = $_SESSION['usuario'];
$login = new login();
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreUsuario);
$idUsuario = $result['id_usu'] ?? null;

if (!$idUsuario) {
    echo "<p>Error: Usuario no encontrado.</p>";
    exit;
}

$modelo = new PerfilModel();
$perfil = $modelo->getData("SELECT * FROM perfiles WHERE id_usu = ?", "i", $idUsuario);

$usuario = $login->getData("SELECT tel FROM usuarios WHERE id_usu = ?", "i", $idUsuario);
$telefono = $usuario['tel'] ?? 'No disponible';
if (!$perfil) {
    echo "<p>No has creado tu perfil aún.</p>";
    exit;
}
?>
<div id="modalPerfil" class="modal">
<div class="modal-contenido modal-contenido--miPerfil">
  <div class="lado-izquierdo">
    <img class="foto-perfil-preview" src="<?php echo $perfil['foto_perfil']; ?>" alt="Foto de perfil">
    <h2><?php echo strtoupper($nombreUsuario); ?></h2>
    <h3>Ciudad, País</h3>
    <p><?php echo $perfil['ciudad']; ?></p>
    <h3>Disponibilidad</h3>
    <p><?php echo $perfil['dias_disponibles']; ?></p>
    <h3>Teléfono</h3>
    <p><?php echo htmlspecialchars($telefono); ?></p>
  </div>

  <div class="lado-derecho">
    <label>Sobre mí</label>
    <textarea disabled><?php echo $perfil['sobre_mi']; ?></textarea>

    <label>Habilidades que puedo enseñar</label>
    <textarea disabled><?php echo $perfil['habilidades_ensenar']; ?></textarea>

    <label>Habilidades que quiero aprender</label>
    <textarea disabled><?php echo $perfil['habilidades_aprender']; ?></textarea>

    <div class="acciones">
      <a href="editar-perfil.php" class="btn-primario" id="btn-editar">Editar Perfil</a>
      <form action="controllers/borrar-perfil-controller.php" method="post" onsubmit="return confirm('¿Estás seguro de que deseas borrar tu perfil?');">
  <button type="submit" class="btn-primario borrar">Borrar Perfil</button>
</form>
      <a href="principal.php" class="btn-primario">Volver</a>
    </div>
  </div>
</div>
</div>


