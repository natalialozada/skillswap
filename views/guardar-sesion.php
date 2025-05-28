<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    
    header('Location: ../index.php');
    exit();  

}
echo "hola: ".$_SESSION["usuario"];

?>

<a href="../cerrar-sesion.php"><?php echo $_SESSION["usuario"]; ?></a>