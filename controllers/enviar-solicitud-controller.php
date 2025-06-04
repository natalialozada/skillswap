<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit;
}

require_once __DIR__ . '/../Db/Con1DB.php';
require_once __DIR__ . '/../models/login-model.php';
require_once __DIR__ . '/../models/conexion-model.php';

$login = new login();
$modelo = new ConexionModel();

$nombreUsuario = $_SESSION['usuario'];
$result = $login->getData("SELECT id_usu FROM usuarios WHERE nombre = ?", "s", $nombreUsuario);
$idRemitente = $result['id_usu'] ?? null;

if (!$idRemitente) {
    echo json_encode(["status" => "error", "message" => "ID remitente no encontrado"]);
    exit;
}

$idDestino = $_POST['id_destino'] ?? null;
if (!$idDestino) {
    echo json_encode(["status" => "error", "message" => "ID destino no proporcionado"]);
    exit;
}

$existe = $modelo->getData(
    "SELECT * FROM conexiones WHERE id_remitente = ? AND id_destino = ?",
    "ii",
    $idRemitente,
    $idDestino
);

if ($existe) {
    echo json_encode(["status" => "error", "message" => "Ya enviaste una solicitud a este usuario"]);
    exit;
}

$sql = "INSERT INTO conexiones (id_remitente, id_destino, estado) VALUES (?, ?, 'pendiente')";
$res = $modelo->insertConexion($sql, "ii", $idRemitente, $idDestino);

echo json_encode($res);
