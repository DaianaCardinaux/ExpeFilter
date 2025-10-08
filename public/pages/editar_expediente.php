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
$datos = $expedientes->buscar(['id' => $id]);
$datoExpediente = $datos[0];

?>

<?php include '../views/header.php'; ?>

<div class="container mt-5">

    <div class="card mb-4 shadow-sm bg-dark text-light">
        <div class="card-body">
            <h4 class="card-title mb-4 text-center">Datos del Expediente</h4>
            <p><strong>Número:</strong> <?= htmlspecialchars($datoExpediente['numero']) ?></p>
            <p><strong>Año:</strong> <?= htmlspecialchars($datoExpediente['anio']) ?></p>
            <p><strong>Sector:</strong> <?= htmlspecialchars($datoExpediente['sector_nombre']) ?></p>
            <p><strong>Tipo:</strong> <?= htmlspecialchars($datoExpediente['tipo_nombre']) ?></p>
            <p><strong>Estado:</strong> <?= htmlspecialchars($datoExpediente['estado_nombre']) ?></p>
            <p><strong>Asunto:</strong> <?= htmlspecialchars($datoExpediente['asunto']) ?></p>
            <p><strong>Creado en:</strong> <?= htmlspecialchars($datoExpediente['creado_en']) ?></p>
            <p><strong>Actualizado en:</strong> <?= htmlspecialchars($datoExpediente['actualizado_en']) ?></p>
        </div>
    </div>

    <div class="card shadow-sm bg-dark text-light">
        <div class="card-body">
            <h4 class="card-title mb-5 text-center">Editar Expediente</h4>

            <?php if ($mensaje !== ''): ?>
                <div class="alert alert-success"><?= $mensaje ?></div>
            <?php endif; ?>

            <form method="POST" class="row g-4 bg-oscuro mb-4">
                <div class="col-2">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control text-light" value="<?= htmlspecialchars($datoExpediente['numero']) ?>">
                </div>

                <div class="col-2">
                    <label class="form-label">Año</label>
                    <input type="text" name="anio" class="form-control text-light" value="<?= htmlspecialchars($datoExpediente['anio']) ?>">
                </div>

                <div class="col-2">
                    <label class="form-label">Tipo</label>
                    <select name="tipo_id" class="form-select">
                        <option value=""><?= htmlspecialchars($datoExpediente['tipo_nombre']) ?></option> 
                        <option value="1">Mesa de Entradas</option> 
                        <option value="2">Comercio</option> 
                        <option value="5">Hacienda</option> 
                        <option value="4">Legales</option> 
                        <option value="3">Obras Públicas</option> 
                    </select>
                </div>

                <div class="col-2">
                    <label class="form-label">Estado</label>
                    <select name="estado_id" class="form-select">
                        <option value=""><?= htmlspecialchars($datoExpediente['estado_nombre']) ?></option> 
                        <option value="1">Mesa de Entradas</option> 
                        <option value="2">Comercio</option> 
                        <option value="5">Hacienda</option> 
                        <option value="4">Legales</option> 
                        <option value="3">Obras Públicas</option> 
                    </select>
                </div>

                <div class="col-3">
                    <label class="form-label">Sector</label>
                    <select name="sector_id" class="form-select">
                        <option value=""><?= htmlspecialchars($datoExpediente['sector_nombre']) ?></option> 
                        <option value="1">Mesa de Entradas</option> 
                        <option value="2">Comercio</option> 
                        <option value="5">Hacienda</option> 
                        <option value="4">Legales</option> 
                        <option value="3">Obras Públicas</option> 
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Asunto</label>
                    <textarea name="asunto" class="form-control text-light" rows="4"><?= htmlspecialchars($datoExpediente['asunto']) ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" name="boton-actualizar" class="btn bg-blue-dark">Actualizar Expediente</button>
                    <a href="./buscar_expediente.php" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
