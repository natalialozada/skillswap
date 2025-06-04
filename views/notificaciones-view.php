<div class="notificaciones-container">
 
  <h2>NOTIFICACIONES</h2>

  <div class="notificaciones-layout">
    <div class="menu-lateral">
      <button class="tab-btn active" data-tab="recibidas">RECIBIDAS</button>
      <button class="tab-btn" data-tab="enviadas">ENVIADAS</button>
    </div>

    <div class="panel-notificaciones">
      <div class="tab-content active" id="recibidas">
        <?php foreach ($solicitudesRecibidas as $sol): ?>
          <div class="fila">
            <span><?php echo htmlspecialchars($sol['nombre']); ?> quiere conectar</span>
            <a href="ver-perfil.php?id=<?php echo $sol['id_remitente']; ?>" class="btn-primario">Ver perfil</a>
            <?php if ($sol['estado'] === 'pendiente'): ?>
              <button class="btn-aceptar btn-primario" data-id="<?php echo $sol['id']; ?>">Aceptar</button>
              <button class="btn-rechazar btn-primario" data-id="<?php echo $sol['id']; ?>">Rechazar</button>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="tab-content" id="enviadas">
        <?php foreach ($solicitudesEnviadas as $sol): ?>
          <div class="fila">
            <span>Quieres conectar con <?php echo htmlspecialchars($sol['nombre']); ?></span>
            <a href="ver-perfil.php?id=<?php echo $sol['id_destino']; ?>" class="btn-primario">Ver perfil</a>
            <span class="estado"><?php echo strtoupper($sol['estado']); ?></span>
          </div>
        <?php endforeach; ?>
        <p class="nota">Recuerda que si aceptan tu solicitud aparecerá el número de teléfono del usuario en su perfil</p>
      </div>
    </div>
  </div>
</div>

</div>
