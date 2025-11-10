<?php
class Users {
    public $email;
    public $password;
    public $conexion;
    public $data;

    public function __construct($conexion, $email, $password){
        $this->conexion = $conexion;
        $this->email = $email;
        $this->password = $password;
        $this->data = null;
    }

    public function cargarUsuario(){
        $stmt = $this->conexion->prepare("SELECT id, email, password_hash, rol, nombre FROM usuarios WHERE email = :email");
        $stmt->execute([":email" => $this->email]);
        $this->data = $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function verificar(){
        if (!$this->data) {
            return false;
        }
        return password_verify($this->password, $this->data['password_hash']);
    }

    public function redirigir(){
        session_regenerate_id(true);
        $_SESSION['id'] = $this->data['id'];
        $_SESSION['nombre'] = $this->data['nombre'] ?? '';
        $_SESSION['email'] = $this->data['email'];
        $_SESSION['rol'] = $this->data['rol'];

        if ($this->data['rol'] === 'admin') {
            header("Location: /public/users/admin.php");
        } else {
            header("Location: /public/users/usuarios.php");
        }
        exit;
    }
}

?>