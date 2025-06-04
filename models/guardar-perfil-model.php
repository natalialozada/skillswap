<?php
require_once __DIR__ . '/../Db/Con1DB.php';

class PerfilModel {
    
    // Método para insertar perfil
    public function insertarPerfil($sql, $typeParameters, ...$params) {
        try {
            $mysqli = Conex1::con1();
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar: " . $mysqli->error);
            }

            $stmt->bind_param($typeParameters, ...$params);

            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar: " . $stmt->error);
            }

            return ["status" => "success", "message" => "Perfil guardado correctamente."];

        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        } finally {
            if ($stmt) $stmt->close();
            $mysqli->close();
        }
    }

    // Método para obtener un solo resultado (ej. comprobar si existe un perfil)
    public function getData($sql, $typeParameters, ...$params) {
        try {
            $mysqli = Conex1::con1();
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la preparación: " . $mysqli->error);
            }

            $stmt->bind_param($typeParameters, ...$params);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();

        } catch (Exception $e) {
            $result = null;
        } finally {
            if ($stmt) $stmt->close();
            $mysqli->close();
        }

        return $result;
    }

    public function getAllUsersExcept($idUsuario) {
        try {
            $mysqli = Conex1::con1();
            $sql = "SELECT u.nombre AS nombre, p.* 
                    FROM perfiles p 
                    JOIN usuarios u ON u.id_usu = p.id_usu 
                    WHERE p.id_usu != ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $idUsuario);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            $result = [];
        } finally {
            if ($stmt) $stmt->close();
            $mysqli->close();
        }
        return $result;
    }

    public function actualizarPerfil($sql, $types, ...$params) {
        try {
            $mysqli = Conex1::con1();
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) throw new Exception("Error preparando: " . $mysqli->error);
    
            $stmt->bind_param($types, ...$params);
            if (!$stmt->execute()) throw new Exception("Error ejecutando: " . $stmt->error);
    
            return ["status" => "success", "message" => "Perfil actualizado"];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        } finally {
            if ($stmt) $stmt->close();
            $mysqli->close();
        }
    }
}


