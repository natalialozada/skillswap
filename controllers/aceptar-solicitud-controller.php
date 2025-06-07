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

// Verifica que la sesión corresponda al destinatario
$usuario = $_SESSION['usuario'];
$datosUsuario = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $usuario);
$idUsuario = $datosUsuario['id_usu'] ?? null;

if ($solicitud['id_destino'] != $idUsuario) {
    echo json_encode(["status" => "error", "message" => "No autorizado"]);
    exit;
}

// Actualiza el estado a aceptado
$success = $modelo->updateData("UPDATE conexiones SET estado = 'aceptado' WHERE id = ?", "i", $idSolicitud);

if ($success) {
    // Ahora que todo fue correcto, insertamos la alerta
    $idRemitente = $solicitud['id_remitente'];
    $mensaje = "$usuario ha aceptado tu solicitud. Ahora puedes ver su teléfono.";

    $modelo->insertarDato(
        "INSERT INTO alertas (id_usuario, mensaje) VALUES (?, ?)",
        "is",
        $idRemitente,
        $mensaje
    );

    echo json_encode(["status" => "success", "message" => "Conexión aceptada"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo actualizar"]);
}
