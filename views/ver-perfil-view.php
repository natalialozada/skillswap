<div class="modal-contenido modal-contenido--miPerfil">
    <div class="lado-izquierdo">
      <img class="foto-perfil-preview" src="<?php echo $perfil['foto_perfil']; ?>" alt="Foto de perfil">
      <h2><?php echo strtoupper($nombreUsuario); ?></h2>
      <p><?php echo $perfil['ciudad']; ?></p>
      <p><?php echo $perfil['dias_disponibles']; ?></p>
    </div>
    <div class="lado-derecho">
      <h3>Sobre mí</h3>
      <p><?php echo nl2br($perfil['sobre_mi']); ?></p>
      <hr>
      <h4>Habilidades que puede enseñar:</h4>
      <ul>
        <?php foreach (explode("\n", $perfil['habilidades_ensenar']) as $item): ?>
          <li><?php echo htmlspecialchars($item); ?></li>
        <?php endforeach; ?>
      </ul>

      <h4>Habilidades que quiere aprender:</h4>
      <ul>
        <?php foreach (explode("\n", $perfil['habilidades_aprender']) as $item): ?>
          <li><?php echo htmlspecialchars($item); ?></li>
        <?php endforeach; ?>
      </ul>

      <a href="principal.php" class="btn-primario">Volver</a>
    </div>
  </div>