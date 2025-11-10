<?php 
    if (isset($_SESSION['id'])) {
        if ($_SESSION['rol'] === 'admin') {
            header("Location: /public/users/admin.php");
        } else {
            header("Location: /public/users/usuarios.php");
        }
    }
?>