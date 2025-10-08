<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExpeFilter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/styles/usuario.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="
                <?php if ($_SESSION['rol'] === 'admin') { 
                    echo "/public/users/admin.php"; 
                } else {
                    echo "/public/users/usuarios.php";
                }  ?>">
                <img src="/assets/images/logo.svg" alt="Logo" class="logoImg">
            </a>
        </div>
        
        <?php if ($_SESSION['rol'] === 'admin'){ ?>
            <a class="navbar-brand d-flex align-items-center text-light mx-4 link" href="<?php echo "/public/users/admin.php"; ?>"> Inicio
            </a>
        <?php } ?>

        <a class="navbar-brand d-flex align-items-center text-light mx-4 link" href="../logout.php">Cerrar sesión</a>
        
    </nav> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>