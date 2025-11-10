<?php
session_start();

if (!isset($_SESSION['id'])) {     
    header("Location: /public/login.php");     
    exit; 
}  

?>

<?php include '../views/header.php'; ?>

<div class="containerBo">
    <a href="../pages/agregar_usuario.php" class="btn btn-light btn-lg">Agregar Usuarios</a>
    <a href="../pages/agregar_expediente.php" class="btn btn-light btn-lg">Agregar Expedientes</a>
    <a href="../pages/buscar_expediente.php" class="btn btn-light btn-lg">Ver Expedientes</a>
</div>




