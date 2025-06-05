<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit;
}

require_once __DIR__ . '/../models/login-model.php';
require_once __DIR__ . '/../models/conexion-model.php';

$login = new login();
$modelo = new ConexionModel();

$nombreUsuario = $_SESSION['usuario'];
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreUsuario);
$idUsuario = $result['id_usu'] ?? null;

if (!$idUsuario) {
    echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
    exit;
}

$idSolicitud = $_POST['id'] ?? null;
$accion = $_POST['accion'] ?? null;

if (!$idSolicitud || !in_array($accion, ['aceptar', 'rechazar'])) {
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    exit;
}

$nuevoEstado = $accion === 'aceptar' ? 'aceptada' : 'rechazada';

$sql = "UPDATE conexiones SET estado = ? WHERE id = ? AND id_destino = ?";
$res = $modelo->updateEstado($sql, "sii", $nuevoEstado, $idSolicitud, $idUsuario);

echo json_encode($res);
