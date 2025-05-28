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

      <form id="form-login">
        <label for="correo">Correo Electrónico</label>
        <input type="text" id="correo" name="correo" required />

        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena"required />

        <input type="submit" value="Iniciar Sesión" class="btn-primario" id="boton-inicio" >
        <a href="registro.php" class="enlace-registro">¿No tienes cuenta? Regístrate</a>
        <div id="resultadoInicia"></div>
      </form>
    </div>
  </div>
</body>
</html>