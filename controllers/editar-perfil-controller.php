<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["status" => "error", "message" => "No autenticado"]);
    exit;
}

require_once "../models/guardar-perfil-model.php";
require_once "../models/login-model.php";

$login = new login();
$usuario = $_SESSION["usuario"];
$res = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $usuario);
$idUsuario = $res['id_usu'] ?? null;

if (!$idUsuario) {
    echo json_encode(["status" => "error", "message" => "ID de usuario no encontrado"]);
    exit;
}

// Procesar imagen si se subió
$fotoRuta = "";
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = uniqid() . "_" . basename($_FILES['foto_perfil']['name']);
    $directorio = "../uploads/";
    if (!is_dir($directorio)) mkdir($directorio, 0777, true);
    $rutaCompleta = $directorio . $nombreArchivo;

    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaCompleta)) {
        $fotoRuta = "uploads/" . $nombreArchivo;
    }
}

$modelo = new PerfilModel();
$sql = "UPDATE perfiles SET ciudad = ?, dias_disponibles = ?, sobre_mi = ?, habilidades_ensenar = ?, habilidades_aprender = ?" .
       ($fotoRuta ? ", foto_perfil = ?" : "") .
       " WHERE id_usu = ?";

// Armar parámetros para actualizar perfil
$params = [
    $_POST['ciudad'],
    $_POST['dias_disponibles'],
    $_POST['sobre_mi'],
    $_POST['habilidades_ensenar'],
    $_POST['habilidades_aprender']
];
$type = "sssss";

if ($fotoRuta) {
    $params[] = $fotoRuta;
    $type .= "s";
}

$params[] = $idUsuario;
$type .= "i";

// Ejecutar actualizaciones
$responsePerfil = $modelo->actualizarPerfil($sql, $type, ...$params);

// Actualizar teléfono en tabla usuarios
$telefono = $_POST['telefono'] ?? '';
$sqlTel = "UPDATE usuarios SET tel = ? WHERE id_usu = ?";
$responseTel = $modelo->actualizarDato($sqlTel, "si", $telefono, $idUsuario);

// Unificar respuesta
if ($responsePerfil['status'] === 'success' && $responseTel['status'] === 'success') {
    echo json_encode(["status" => "success", "message" => "Perfil actualizado correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "Hubo un problema actualizando el perfil o el teléfono"]);
}
