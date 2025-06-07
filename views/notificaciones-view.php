<div class="notificaciones-container">
  <h2 class="titulo-notificaciones">CONEXIONES</h2>

  <div class="notificaciones-layout">
    <div class="menu-lateral">
      <button class="tab-btn active" data-tab="recibidas">Recibidas</button>
      <button class="tab-btn" data-tab="enviadas">Enviadas</button>
    </div>

    <div class="panel-notificaciones">
      <div class="tab-content active" id="recibidas">
        <?php foreach ($solicitudesRecibidas as $sol): ?>
          <div class="fila">
            <div>
              <strong><?php echo htmlspecialchars($sol['nombre']); ?></strong> quiere conectar
            </div>
            <div class="acciones">
              <a href="ver-perfil.php?id=<?php echo $sol['id_remitente']; ?>" class="btn-primario">Ver perfil</a>

              <?php if ($sol['estado'] === 'pendiente'): ?>
                <button class="btn-aceptar btn-primario" data-id="<?php echo $sol['id']; ?>">Aceptar</button>
                <button class="btn-rechazar btn-primario" data-id="<?php echo $sol['id']; ?>">Rechazar</button>
              <?php else: ?>
                <span class="estado"><?php echo strtoupper($sol['estado']); ?></span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="tab-content" id="enviadas">
        <?php foreach ($solicitudesEnviadas as $sol): ?>
          <div class="fila">
            <div>
              Quieres conectar con <strong><?php echo htmlspecialchars($sol['nombre']); ?></strong>
            </div>
            <div class="acciones">
              <a href="ver-perfil.php?id=<?php echo $sol['id_destino']; ?>" class="btn-primario smaller">Ver perfil</a>
              <span class="estado"><?php echo strtoupper($sol['estado']); ?></span>

              <?php if ($sol['estado'] === 'aceptada'): ?>
                <p class="telefono">Teléfono: <?php echo htmlspecialchars($sol['tel_destino']); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
        <p class="nota">Recuerda que si aceptan tu solicitud aparecerá el número de teléfono del usuario en su perfil</p>
      </div>
    </div>
  </div>
</div>
