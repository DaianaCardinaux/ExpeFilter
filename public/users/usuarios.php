<?php
session_start();

if (!isset($_SESSION['id'])) {     
    header("Location: /public/login.php");     
    exit; 
}  

if (!empty($_SESSION['id'])) {     
    header("Location: /public/pages/buscar_expediente.php");     
    exit; 
}  


?>


