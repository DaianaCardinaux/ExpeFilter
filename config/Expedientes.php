<?php

class Expedientes {
    private $conn;
    public $sql = "SELECT exp.*, s.nombre AS sector_nombre, t.nombre AS tipo_nombre, e.nombre AS estado_nombre 
            FROM expedientes exp LEFT JOIN sectores s ON exp.sector_id = s.id LEFT JOIN tipos_expediente t ON exp.tipo_id = t.id LEFT JOIN estados e ON exp.estado_id = e.id 
            WHERE 1=1";

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function buscar($filtros = []) {
        $this->sql = "SELECT exp.*, s.nombre AS sector_nombre, t.nombre AS tipo_nombre, e.nombre AS estado_nombre 
                  FROM expedientes exp LEFT JOIN sectores s ON exp.sector_id = s.id LEFT JOIN tipos_expediente t ON exp.tipo_id = t.id LEFT JOIN estados e ON exp.estado_id = e.id 
                  WHERE 1=1";
        $params = [];

        if (!empty($filtros['id'])) {
            $this->sql .= " AND exp.id = :id";
            $params[':id'] = $filtros['id'];
        }

        if (!empty($filtros['numero'])) {
            $this->sql .= " AND exp.numero = :numero";
            $params[':numero'] = $filtros['numero'];
        }

        if (!empty($filtros['anio'])) {
            $this->sql .= " AND exp.anio = :anio";
            $params[':anio'] = $filtros['anio'];
        }

        if (!empty($filtros['sector_id'])) {
            $this->sql .= " AND exp.sector_id = :sector_id";
            $params[':sector_id'] = $filtros['sector_id'];
        }

        if (!empty($filtros['asunto'])) {
            $this->sql .= " AND exp.asunto LIKE :asunto";
            $params[':asunto'] = "%" . $filtros['asunto'] . "%";
        }

        $stmt = $this->conn->prepare($this->sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function agregarExpediente($numero, $anio, $sector_id, $tipo_id, $estado_id, $asunto) {
        $this->sql = "INSERT INTO expedientes (numero, anio, sector_id, tipo_id, estado_id, asunto)
                    VALUES (:numero, :anio, :sector_id, :tipo_id, :estado_id, :asunto)";
        
        $stmt = $this->conn->prepare($this->sql);

        return $stmt->execute([
            ':numero' => $numero,
            ':anio' => $anio,
            ':sector_id' => $sector_id,
            ':tipo_id' => $tipo_id,
            ':estado_id' => $estado_id,
            ':asunto' => $asunto
        ]);
    }

    public function actualizarExpediente($id, $numero, $anio, $sector_id, $tipo_id, $estado_id, $asunto) {
        $this->sql = "UPDATE expedientes 
                SET numero = :numero, anio = :anio, sector_id = :sector_id, tipo_id = :tipo_id, estado_id = :estado_id, asunto = :asunto
                WHERE id = :id";

        $stmt = $this->conn->prepare($this->sql);

        return $stmt->execute([
            ':id' => $id,
            ':numero' => $numero,
            ':anio' => $anio,
            ':sector_id' => $sector_id,
            ':tipo_id' => $tipo_id,
            ':estado_id' => $estado_id,
            ':asunto' => $asunto
        ]);
    }

    public function eliminarExpediente($id) {
        $this->sql = "DELETE FROM expedientes WHERE id = :id";
        $stmt = $this->conn->prepare($this->sql);
        return $stmt->execute([':id' => $id]);
    }

}
