<?php

header('Content-Type: application/json');
session_start();
try {

    $correo = $_POST['correo'] ?? null;
    $contrasena = $_POST['contrasena'] ?? null;
    if (!$correo || !$contrasena) {
        throw new Exception("Correo, y contraseña son obligatorios.");
    }


    require_once "../models/login-model.php";
    
    $login = new login();
    $sql = "SELECT contrasena FROM usuarios WHERE correo = ?";
    $typeParameters = "s"; 
    $result = $login->getData($sql, $typeParameters, $correo);

    if ($result && password_verify($contrasena, $result['contrasena'])) {
        $sql1="SELECT nombre FROM usuarios WHERE correo = ?";
        $typeParameters1 = "s"; 
        $result1 = $login->getData($sql1, $typeParameters1, $correo);
        $_SESSION["usuario"]= $result1['nombre'];
        

        echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso."]);
    } else {
        
        throw new Exception("Credenciales inválidas.");
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

?>
