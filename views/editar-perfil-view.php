<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../models/login-model.php';
require_once __DIR__ . '/../models/guardar-perfil-model.php';

$login = new login();
$nombreUsuario = $_SESSION['usuario'];
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreUsuario);
$idUsuario = $result['id_usu'] ?? null;

if (!$idUsuario) {
    echo "<p>Error: Usuario no encontrado.</p>";
    exit;
}

$modelo = new PerfilModel();
$perfil = $modelo->getData("SELECT * FROM perfiles WHERE id_usu = ?", "i", $idUsuario);
if (!$perfil) {
    echo "<p>No has creado tu perfil.</p>";
    exit;
}
?>

<div id="modalPerfil" class="modal">
  <div class="modal-contenido--miPerfil">
    <form id="form-editar-perfil" enctype="multipart/form-data" method="post">
      <div class="lado-izquierdo">
        <img src="<?php echo $perfil['foto_perfil']; ?>" class="foto-perfil-preview" id="preview-img" />
        <div class="input-file-personalizado">
          <label for="foto_perfil" class="custom-file-label">Cambiar foto</label>
          <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*" />
          <h2><?php echo strtoupper($nombreUsuario); ?></h2>
        <h3>Ciudad, País</h3>
        <input type="text" name="ciudad" placeholder="Ciudad, País" value="<?php echo htmlspecialchars($perfil['ciudad']); ?>" required />
        <h3>Disponibilidad</h3>
        <input type="text" name="dias_disponibles" placeholder="Días disponibles" value="<?php echo htmlspecialchars($perfil['dias_disponibles']); ?>" required />
        </div>
        
      </div>

      <div class="lado-derecho">
        <label>Sobre mí</label>
        <textarea name="sobre_mi" required><?php echo $perfil['sobre_mi']; ?></textarea>

        <label>Habilidades que puedo enseñar</label>
        <textarea name="habilidades_ensenar" required><?php echo $perfil['habilidades_ensenar']; ?></textarea>

        <label>Habilidades que quiero aprender</label>
        <textarea name="habilidades_aprender" required><?php echo $perfil['habilidades_aprender']; ?></textarea>

        <div class="acciones">
        <button type="submit" class="btn-primario">Guardar Cambios</button>
        <a href="mi-perfil.php" class="btn-primario">Volver</a>
        </div>
      </div>
    </form>
  </div>
</div>
