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

$mensaje = '';

if (isset($_POST['boton-agregar'])) {
    $numero = $_POST['numero'];
    $anio = $_POST['anio'];
    $sector_id = $_POST['sector_id'];
    $tipo_id = $_POST['tipo_id'];
    $estado_id = $_POST['estado_id'];
    $asunto = $_POST['asunto'];

    if ($numero == "" or $anio == "" or $sector_id == "" or $tipo_id == "" or $estado_id == "" or $asunto == "") {
        $mensaje = "Ingresa los datos";
    } else {
        $agregado = $expedientes->agregarExpediente($numero, $anio, $sector_id, $tipo_id, $estado_id, $asunto);

        if ($agregado) {
            $mensaje = "Expediente agregado";
        } else {
            $mensaje = "Ingresa los datos completos";
        }
    }
}

?>

<?php include '../views/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-sm bg-dark text-light">
        <div class="card-body">
            <h4 class="card-title mb-5 text-center">Agregar Expediente Nuevo</h4>

            <?php if ($mensaje !== ''): ?>
                <div class="alert alert-warning"><?= $mensaje ?></div>
            <?php endif; ?>

            <form method="POST" class="row g-4 bg-oscuro mb-4">
                <div class="col-2">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control text-light" value="">
                </div>

                <div class="col-2">
                    <label class="form-label">Año</label>
                    <input type="text" name="anio" class="form-control text-light" value="">
                </div>

                <div class="col-2">
                    <label class="form-label">Tipo</label>
                        <select name="tipo_id" class="form-select">
                            <option value=""></option> 
                            <option value="1">Licencia</option> 
                            <option value="2">Reclamo</option> 
                            <option value="3">Obra</option> 
                            <option value="4">Permiso</option> 
                            <option value="5">Otro</option> 
                        </select>
                </div>

                <div class="col-2">
                    <label class="form-label">Estado</label>
                        <select name="estado_id" class="form-select">
                            <option value=""></option> 
                            <option value="1">En tramite</option> 
                            <option value="2">Finalizar</option> 
                            <option value="3">Pendiente</option> 
                            <option value="4">Archivado</option> 
                        </select>
                </div>

                <div class="col-3">
                    <label class="form-label">Sector</label>
                    <select name="sector_id" class="form-select">
                        <option value=""></option> 
                        <option value="1">Mesa de Entradas</option> 
                        <option value="2">Comercio</option> 
                        <option value="3">Obras Públicas</option> 
                        <option value="4">Legales</option> 
                        <option value="5">Hacienda</option> 
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Asunto</label>
                    <textarea name="asunto" class="form-control text-light" rows="4"></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" name="boton-agregar" class="btn bg-blue-dark">Agregar Expediente</button>
                    <a href="./buscar_expediente.php" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
