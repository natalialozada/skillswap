<?php
require_once __DIR__ . '/../Db/Con1DB.php';

class ConexionModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Conex1::con1();
    }

    public function insertConexion($sql, $types, ...$params)
    {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return ["status" => "error", "message" => "Error al preparar: " . $this->conn->error];
        }

        $stmt->bind_param($types, ...$params);
        $success = $stmt->execute();

        if ($success) {
            return ["status" => "success", "message" => "Solicitud enviada"];
        } else {
            return ["status" => "error", "message" => "Error al insertar: " . $stmt->error];
        }
    }

    public function getData($sql, $types, ...$params)
    {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAll($sql, $types, ...$params)
    {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function updateData($sql, $types, ...$params)
{
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param($types, ...$params);
    return $stmt->execute();
}

}
