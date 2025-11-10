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

$resultados = []; 
$mensaje = "";

if (isset($_POST['boton-buscar'])) {     
    $filtros = [         
        'numero' => $_POST['numero'] ?? '',         
        'anio' => $_POST['anio'] ?? '',         
        'sector_id' => $_POST['sector_id'] ?? '',   
        'tipo_id' => $_POST['tipo_id'] ?? '', 
        'estado_id' => $_POST['estado_id'] ?? '',       
        'asunto' => $_POST['asunto'] ?? ''     
    ];

    $resultados = $expedientes->buscar($filtros);

    if (empty($resultados)) {
        $mensaje = "Expediente no encontrado";
    }
}

if (isset($_POST['boton-limpiar'])) {  
    header("Location: ./buscar_expediente.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    if ($expedientes->eliminarExpediente($id)) {
        $mensaje = "Expediente eliminado correctamente";
    } else {
        $mensaje = "Error al eliminar expediente";
    }

    $resultados = $expedientes->buscar();
}
?>  

<?php include '../views/header.php'; ?>

<div class="container mt-5">
    <div class="card mb-4 shadow-sm bg-dark text-light">
        <div class="card-body">
            <h4 class="card-title mb-5 text-center">Buscar Expedientes</h4>
            
            <form method="POST" class="row g-4">
                <div class="col-3">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" name="numero" id="numero" class="form-control text-light" value="<?= $_POST['numero'] ?? '' ?>">
                </div>
                <div class="col-3">
                    <label for="anio" class="form-label">Año</label>
                    <input type="text" name="anio" id="anio" class="form-control text-light" value="<?= $_POST['anio'] ?? '' ?>">
                </div>
                <div class="col-3">
                    <label for="sector_id" class="form-label">Sector</label>
                    <select name="sector_id" id="sector_id" class="form-select">
                        <option value="">Seleccionar Sector</option> 
                        <option value="1">Mesa de Entradas</option> 
                        <option value="2">Comercio</option> 
                        <option value="5">Hacienda</option> 
                        <option value="4">Legales</option> 
                        <option value="3">Obras Públicas</option> 
                    </select>
                </div>
                <div class="col-3">
                    <label for="asunto" class="form-label">Asunto</label>
                    <input type="text" name="asunto" id="asunto" class="form-control text-light" value="<?= $_POST['asunto'] ?? '' ?>">
                </div>

                <div class="col-12 text-center">
                    <button type="submit" name="boton-buscar" class="btn btn-primary">Buscar</button>
                    <button type="submit" name="boton-limpiar" class="btn btn-secondary">Limpiar</button>
                </div>
            </form>

            <?php if ($mensaje != "") { ?>
                <div class="alert alert-info mt-4 text-center"><?= $mensaje ?></div>
            <?php } ?>
        </div>
    </div>

    <?php if (!empty($resultados)) { ?>
    <div class="card shadow-md">
        <div class="card-body bg-dark text-light">
            <h4 class="text-center mb-4">Expedientes</h4>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>Número</th><th>Año</th><th>Sector</th><th>Tipo</th><th>Estado</th><th>Asunto</th><th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($resultados as $exp) { ?>
                        <tr>
                            <td><?= $exp['numero'] ?></td>
                            <td><?= $exp['anio'] ?></td>
                            <td><?= $exp['sector_nombre'] ?></td>
                            <td><?= $exp['tipo_nombre'] ?></td>
                            <td><?= $exp['estado_nombre'] ?></td>
                            <td><?= $exp['asunto'] ?></td>
                            <td>
                                <a href="./ver_expediente.php?id=<?= $exp['id'] ?>" class="btn btn-sm btn-light">Ver</a>
                                <?php if ($_SESSION['rol'] === 'admin') { ?>
                                    <a href="./editar_expediente.php?id=<?= $exp['id'] ?>" class="btn btn-sm btn-secondary">Editar</a>
                                    <a href="./buscar_expediente.php?eliminar=<?= $exp['id'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
