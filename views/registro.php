<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRINCIPAL | SKILL-SWAP</title>
    <link rel="icon" href="Assets/img/logo-sin-fondo.png" type="image/x-icon"> 
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
<div class="contenedor-principal">
<div class="contenedor-login">
    <div class="login-caja">
      <img class="logo-img" src="assets/img/logo-sin-fondo.png" alt="SkillSwap Logo" />
      <img class="logo-texto" src="assets/img/nombre-skill-swap.png" alt="SkillSwap nombre" />

      <form id="form-registro">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required />

        <label for="correo">Correo Electrónico</label>
        <input type="text" id="correo" name="correo" required />

        <label for="contra">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" required />

        <input type="submit" value="Registrarse" class="btn-primario" id="boton-registro" >
        <a href="login.php" class="enlace-registro">¿Ya tienes cuenta? Inicia Sesión</a>
        <div id="resultadoRegistro"></div>
      </form>
    </div>
  </div>
</body>
</html>