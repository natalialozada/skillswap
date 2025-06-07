<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["status" => "error", "message" => "No autenticado"]);
    exit;
}

require_once __DIR__ . '/../models/conexion-model.php';
require_once __DIR__ . '/../models/login-model.php';

$login = new login();
$modelo = new ConexionModel();

$idSolicitud = $_POST['id'] ?? null;

if (!$idSolicitud) {
    echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
    exit;
}

// Verifica si la solicitud existe
$solicitud = $modelo->getData("SELECT * FROM conexiones WHERE id = ?", "i", $idSolicitud);

if (!$solicitud) {
    echo json_encode(["status" => "error", "message" => "Solicitud no encontrada"]);
    exit;
}


$usuario = $_SESSION['usuario'];
$datosUsuario = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $usuario);
$idUsuario = $datosUsuario['id_usu'] ?? null;

if ($solicitud['id_destino'] != $idUsuario) {
    echo json_encode(["status" => "error", "message" => "No autorizado"]);
    exit;
}


$success = $modelo->updateData("UPDATE conexiones SET estado = 'rechazada' WHERE id = ?", "i", $idSolicitud);

if ($success) {
    echo json_encode(["status" => "success", "message" => "Solicitud rechazada"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo actualizar"]);
}
