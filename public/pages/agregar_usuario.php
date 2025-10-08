<?php
session_start();
require_once('../../config/db.php');
require_once('../../config/User.php');

if (!isset($_SESSION['id'])) {     
    header("Location: /public/login.php");     
    exit; 
}  

$db = new Database();
$conexion = $db->connect();

$usuarios = new Usuarios($conexion);

$mensaje = "";

    if (isset($_POST['boton_crear'])) {
        $nombre   = $_POST['nombre'] ?? '';
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $rol      = $_POST['rol'] ?? 'usuario';

        if ($usuarios->crearUsuarios($nombre, $email, $password, $rol)) {
            $mensaje = "Usuario ingresado";
        } else {
            $mensaje = "Error al crear Usuario";
        }

        header("Location: ./agregar_usuario.php");
        exit;
    }

$user = $usuarios->obtenerUsuarios();
?>

<?php include '../views/header.php'; ?>

<div class="container my-2 mt-5">
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info text-center"><?= $mensaje ?></div>
    <?php endif; ?>    

    <div class="card bg-dark text-light shadow-sm mb-4">
        <div class="card-header text-center">
            <h5 class="mb-0">Crear nuevo usuario</h5>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3 bg-oscuro ">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input class="form-control text-light border-0" type="text" name="nombre" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control text-light border-0" type="email" name="email" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contraseña</label>
                    <input class="form-control text-light border-0" type="text" name="password" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select text-light border-0 bg-oscuro">
                        <option value="usuario">Usuario</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button class="btn bg-blue-dark px-4" type="submit" name="boton_crear">Crear usuario</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-dark text-light shadow-sm">
        <div class="card-header text-center">
            <h5 class="mb-0">Usuarios registrados</h5>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="bg-oscuro">
                    <tr>
                        <th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user as $u): ?>
                        <tr class="bg-oscuro">
                            <td><?= htmlspecialchars($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['nombre']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['rol']) ?></td>
                            <td><?= htmlspecialchars($u['creado_en']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
