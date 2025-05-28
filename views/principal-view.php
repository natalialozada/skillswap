<?php
session_start();

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

$mostrarModal = false;

if ($idUsuario) {
    $modelo = new PerfilModel();
    $perfil = $modelo->getData("SELECT * FROM perfiles WHERE id_usu = ?", "i", $idUsuario);
    if (!$perfil) {
        $mostrarModal = true;
    }
}

?>

<div class="contenedor-sesion">
    <div class="usuario">
        Hola, <?php echo $_SESSION["usuario"]; ?>
    </div>
    <a href="views/cerrar-sesion.php" class="cerrar-sesion">Cerrar Sesión</a>
</div>


<?php if ($mostrarModal): ?>
<div id="modalPerfil" class="modal">

  <div class="modal-contenido">
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
      </div>

      <div class="lado-derecho">
        <label>Sobre mí</label>
        <textarea name="sobre_mi" placeholder="cuéntanos brevemente sobre ti" required></textarea>

        <label>Habilidades que puedo enseñar</label>
        <textarea name="habilidades_ensenar" placeholder="por ejemplo piano, guitarra..." required></textarea>

        <label>Habilidades que quiero aprender</label>
        <textarea name="habilidades_aprender" placeholder="por ejemplo patinar, programar..." required></textarea>

        <button type="submit" class="btn-primario">Guardar Perfil</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>


