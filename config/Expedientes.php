<?php

class Expedientes {
    private $conn;

    function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function buscar($filtros = []) {
        $sql = "SELECT exp.*, s.nombre AS sector_nombre, t.nombre AS tipo_nombre, e.nombre AS estado_nombre 
                FROM expedientes exp LEFT JOIN sectores s ON exp.sector_id = s.id LEFT JOIN tipos_expediente t ON exp.tipo_id = t.id LEFT JOIN estados e ON exp.estado_id = e.id 
                WHERE 1=1";

        $params = [];

        if (!empty($filtros['id'])) {
            $sql .= " AND exp.id = :id";
            $params[':id'] = $filtros['id'];
        }

        if (!empty($filtros['numero'])) {
            $sql .= " AND exp.numero = :numero";
            $params[':numero'] = $filtros['numero'];
        }

        if (!empty($filtros['anio'])) {
            $sql .= " AND exp.anio = :anio";
            $params[':anio'] = $filtros['anio'];
        }

        if (!empty($filtros['sector_id'])) {
            $sql .= " AND exp.sector_id = :sector_id";
            $params[':sector_id'] = $filtros['sector_id'];
        }

        if (!empty($filtros['asunto'])) {
            $sql .= " AND exp.asunto LIKE :asunto";
            $params[':asunto'] = "%" . $filtros['asunto'] . "%";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
