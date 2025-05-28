<?php
 
// Configurar el encabezado de respuesta como JSON
header('Content-Type: application/json');
 
try {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $contrasena = $_POST['contrasena'] ?? null;
 
    // Validar que los datos no estén vacíos
    if (!$nombre || !$correo|| !$contrasena) {
        throw new Exception("Todos los campos son obligatorios.");
    }
 
    // Cifrar la contraseña
    $contraCifrada = password_hash($contrasena, PASSWORD_DEFAULT);
    if (!$contraCifrada) {
        throw new Exception("Error al cifrar la contraseña.");
    }
 
    // Incluir el modelo y crear una instancia
    require_once "../models/registro-model.php";
    $obj1 = new Datos();
   
 
    // Definir la instrucción SQL y los tipos de parámetros
    $sql1 = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)";
    $typeParameters = "sss"; // String para todos los campos
 
    // Llamar al método del modelo para insertar los datos
    $data1 = $obj1->insertData($sql1, $typeParameters, $nombre,$correo, $contraCifrada);
 
    // Enviar la respuesta como JSON
    echo json_encode($data1);
 
} catch (Exception $e) {
    // Manejo de excepciones y respuesta de error en JSON
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
 
?>