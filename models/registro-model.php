<?php
 
// Incluir el método para la conexión a la base de datos
require_once __DIR__ . '/../Db/Con1DB.php';
 
class Datos
{
    // Método para ejecutar consultas de inserción, modeficación y eliminación con parámetros preparados
    public function insertData($sql, $typeParameters, ...$params)
    {
        try {
            // Conexión a la base de datos
            $mysqli = Conex1::con1();
 
            // Preparar la sentencia SQL
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $mysqli->error);
            }
 
            // Vincular los parámetros a la sentencia preparada
            $stmt->bind_param($typeParameters, ...$params);
 
            // Intento de ejecución de la instrucción
            if (!$stmt->execute()) {
                throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
            }
 
            // Éxito en la ejecución
            $result = ["status" => "success", "message" => "Operación realizada con éxito."];
 
        } catch (Exception $e) {
            // Error en la ejecución
            $result = ["status" => "error", "message" => $e->getMessage()];
        } finally {
            // Cierre de la conexión y la sentencia
            if ($stmt) $stmt->close();
            $mysqli->close();
        }
 
        // Devolver el resultado de la operación
        return $result;
    }
}
?>