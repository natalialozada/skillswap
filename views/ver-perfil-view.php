<div class="modal">
<div class="modal-contenido modal-contenido--miPerfil">
  <div class="lado-izquierdo">
    <img class="foto-perfil-preview" src="<?php echo $perfil['foto_perfil']; ?>" alt="Foto de perfil">
    <h2><?php echo strtoupper($nombreUsuario); ?></h2>

    <h3>Ciudad</h3>
    <p><?php echo $perfil['ciudad']; ?></p>

    <h3>Días disponibles</h3>
    <p><?php echo $perfil['dias_disponibles']; ?></p>
  </div>

  <div class="lado-derecho">
    <label>Sobre mí</label>
    <textarea disabled><?php echo $perfil['sobre_mi']; ?></textarea>

    <label>Habilidades que puede enseñar</label>
    <textarea disabled><?php echo $perfil['habilidades_ensenar']; ?></textarea>

    <label>Habilidades que quiere aprender</label>
    <textarea disabled><?php echo $perfil['habilidades_aprender']; ?></textarea>

    <label>Teléfono</label>
    <?php if ($mostrarTelefono && $telefonoUsuario): ?>
      <p><?php echo htmlspecialchars($telefonoUsuario); ?></p>
    <?php else: ?>
      <p class="texto-bloqueado">Solo visible cuando haya una conexión aceptada</p>
    <?php endif; ?>

    <a href="notificaciones.php" class="btn-primario">Volver</a>
  </div>
</div>
</div>
