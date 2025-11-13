<?php
    class Usuarios {
        public $conexion;

        public function __construct($conexion){
            $this->conexion = $conexion;
        }

        public function obtenerUsuarios(){
            $stmt = $this->conexion->query("SELECT id, nombre, email, rol, creado_en FROM usuarios");
            return $stmt;
        }

        public function crearUsuarios($nombre, $email, $password, $rol = 'usuario'){
            $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :eml");
            $stmt->execute([":eml" => $email]);
            $existe = $stmt;

            if ($existe > 0) {
                return false;
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->conexion->prepare(
                "INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES (:nom, :eml, :pass, :rl)"
            );
            
            return $stmt->execute([
                ":nom" => $nombre,
                ":eml" => $email,
                ":pass" => $hash,
                ":rl" => $rol,
            ]);
        }
    }

?>
