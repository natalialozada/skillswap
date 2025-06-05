<?php
header('Content-Type: application/json'); // Siempre antes de cualquier salida

session_start();
if (!isset($_SESSION['usuario'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit;
}

require_once "../Db/Con1DB.php";
require_once "../models/guardar-perfil-model.php";
require_once "../models/login-model.php";

$login = new login();
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $_SESSION['usuario']);
$idUsuario = $result['id_usu'] ?? null;

if (!$idUsuario) {
    echo json_encode(["status" => "error", "message" => "ID de usuario no encontrado"]);
    exit;
}

$fotoRuta = "";
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = uniqid() . "_" . basename($_FILES['foto_perfil']['name']);
    $directorio = "../uploads/";
    if (!is_dir($directorio)) mkdir($directorio, 0777, true);
    $rutaCompleta = $directorio . $nombreArchivo;
    $rutaPublica = "uploads/" . $nombreArchivo;

    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaCompleta)) {
        $fotoRuta = $rutaPublica;
    }
}

// Datos del formulario
$nombre = $_POST['nombre'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$dias = $_POST['dias_disponibles'] ?? '';
$sobreMi = $_POST['sobre_mi'] ?? '';
$ensenar = $_POST['habilidades_ensenar'] ?? '';
$aprender = $_POST['habilidades_aprender'] ?? '';
$telefono = $_POST['telefono'] ?? '';

// Guardar en tabla perfiles
$modelo = new PerfilModel();
$sqlPerfil = "INSERT INTO perfiles (id_usu, ciudad, dias_disponibles, sobre_mi, habilidades_ensenar, habilidades_aprender, foto_perfil)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
$respuestaPerfil = $modelo->insertarPerfil($sqlPerfil, "issssss", $idUsuario, $ciudad, $dias, $sobreMi, $ensenar, $aprender, $fotoRuta);

// Guardar teléfono en tabla usuarios
$sqlTel = "UPDATE usuarios SET tel = ? WHERE id_usu = ?";
$respuestaTel = $modelo->actualizarDato($sqlTel, "si", $telefono, $idUsuario);

// Combinar respuestas
if ($respuestaPerfil['status'] === 'success' && $respuestaTel['status'] === 'success') {
    echo json_encode(["status" => "success", "message" => "Perfil guardado correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "Hubo un problema al guardar el perfil o el teléfono"]);
}
?>
