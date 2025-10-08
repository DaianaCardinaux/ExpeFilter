<?php 
session_start();
require_once('../../config/db.php'); 
require_once('../../config/Expedientes.php');   

if (!isset($_SESSION['id'])) {     
    header("Location: /public/login.php");     
    exit; 
}  

$db = new Database();
$conexion = $db->connect();

$expedientes = new Expedientes($conexion);

$id = $_GET['id'];
$datoExpediente = $expedientes->buscar(['id' => $id]);

?>

<?php include '../views/header.php'; ?>

<div class="container mt-5">
    <div class="card mb-4 shadow-sm bg-dark text-light">
        <div class="card-body">
            <?php foreach ($datoExpediente as $exp){ ?>
                <h4 class="card-title mb-4 text-center">Datos del Expediente</h4>
                    <p><strong>Número:</strong> <?= htmlspecialchars($exp['numero']) ?></p>
                    <p><strong>Año:</strong> <?= htmlspecialchars($exp['anio']) ?></p>
                    <p><strong>Sector:</strong> <?= htmlspecialchars($exp['sector_nombre']) ?></p>
                    <p><strong>Tipo:</strong> <?= htmlspecialchars($exp['tipo_nombre']) ?></p>
                    <p><strong>Estado:</strong> <?= htmlspecialchars($exp['estado_nombre']) ?></p>
                    <p><strong>Asunto:</strong> <?= htmlspecialchars($exp['asunto']) ?></p>
                    <p><strong>Creado en:</strong> <?= htmlspecialchars($exp['creado_en']) ?></p>
                    <p><strong>Actualizado en:</strong> <?= htmlspecialchars($exp['actualizado_en']) ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="col-12">
        <a href="./buscar_expediente.php" class="btn btn-secondary">Volver</a>
    </div>
</div>