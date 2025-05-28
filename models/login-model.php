<?php

require_once __DIR__ . '/../Db/Con1DB.php';

class login
{
    public function getData($sql, $typeParameters, ...$params)
    {
        try {
            $mysqli = Conex1::con1();

            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $mysqli->error);
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
}
?>