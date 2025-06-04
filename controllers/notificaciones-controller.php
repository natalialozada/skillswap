<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

require_once __DIR__ . '/../Db/Con1DB.php';
require_once __DIR__ . '/../models/login-model.php';
require_once __DIR__ . '/../models/conexion-model.php';

$login = new login();
$modelo = new ConexionModel();

$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $_SESSION['usuario']);
$idUsuario = $result['id_usu'] ?? null;

if (!$idUsuario) {
    echo json_encode(['status' => 'error', 'message' => 'ID usuario no encontrado']);
    exit;
}

// Contar solicitudes pendientes recibidas
$sql = "SELECT COUNT(*) as total FROM conexiones WHERE id_destino = ? AND estado = 'pendiente'";
$data = $modelo->getData($sql, "i", $idUsuario);

echo json_encode(['status' => 'success', 'count' => $data['total'] ?? 0]);
