<?php
session_start();
require_once('/config/db.php');
require_once('/config/Auth.php');
require_once('/config/check.php');

$db = new Database();
$conexion = $db->connect();

$error = "";

    if (isset($_POST['login_button'])) {

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            $error = "Completa el formulario";
            $_POST = [];
            
        } else {
            $asignar = new Users($conexion, $email, $password);
            $asignar->cargarUsuario();

            if ($asignar->verificar()) {
                $asignar->redirigir();

            } else {
                $error = "Usuario o Contraseña incorrectos";
                $_POST = [];
            }
        }
    }
 
     ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expefilter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/styles/style.css">
</head>
<body>
    <div class="login-card">
        <div class="row g-0">
            <div class="col-md-6 left-panel">
                  <div class="overlay">
                      <h2 class="fw-bold">¡Bienvenido de nuevo!</h2>
                      <p>Accede a tu cuenta de expedientes</p> 
                  </div>
                <img src="/assets/images/logoBlack.png" alt="Imagen de fondo">
            </div>

        <div class="col-md-6 form-section a">
            <h3 class="mb-4 text-center">Iniciar Sesión</h3>

                <?php if ($error != ""): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group mb-4 mt-4">
                        <input type="text" name="email" class="form-control" placeholder="Correo electrónico" required>
                    </div>
                    <div class="form-group mb-4 mt-4">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" name="login_button" class="btn btn-primary mt-4">Acceder</button>
                </form>
        </div>
        </div>
    </div>
</body>

    <!-- <div class="helper" style="margin-top:10px; color:white">
        admin@demo.local / Admin123! • usuario@demo.local / User123!
        admin@agregado.com / adminAgregado!
    </div> -->
</html>
