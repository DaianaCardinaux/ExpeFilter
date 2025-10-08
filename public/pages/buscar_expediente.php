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
$error = '';


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
            $error = "Expediente no encontrado";
        }

    } else {
        $resultados = $expedientes->buscar();
    }

    if (isset($_POST['boton-limpiar'])) {  
        $_POST = [];
        header("Location: ./buscar_expediente.php");
        exit;
    }

?>  

<?php include '../views/header.php'; ?>

<div class="container mt-5">
    <div class="card mb-4 shadow-sm bg-dark text-light">
        <div class="card-body">
            <h4 class="card-title mb-5 text-center">Buscar Expedientes</h4>
            <form method="POST" class="row g-4 bg-oscuro mb-4">
                <div class="col-md-3">
                    <label for="numero" class="form-label">Numero</label>
                    <input type="text" name="numero" id="numero" class="form-control text-light" placeholder="Ingresa Numero" value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="anio" class="form-label">Año</label>
                    <input type="text" name="anio" id="anio" class="form-control text-light" placeholder="Ingresa Año" value="<?= htmlspecialchars($_POST['anio'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="sector_id" class="form-label">Sector</label>
                    <select name="sector_id" id="sector_id" class="form-select">
                        <option class="optionSelec" value="">Seleccionar Sector</option> 
                        <option value="1">Mesa de Entradas</option> 
                        <option value="2">Comercio</option> 
                        <option value="5">Hacienda</option> 
                        <option value="4">Legales</option> 
                        <option value="3">Obras Públicas</option> 
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="asunto" class="form-label">Asunto</label>
                    <input type="text" name="asunto" id="asunto" class="form-control text-light" placeholder="Ingresa Asunto" value="<?= htmlspecialchars($_POST['asunto'] ?? '') ?>">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-blue-dark" name="boton-buscar">Buscar</button>
                    <button type="submit"  class="btn bg-blue-dark" name="boton-limpiar">Limpiar Filtro</button>
                </div>
            </form>

        <?php if (isset($_POST['boton-buscar']) && $error !== ""){ ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php } ?>

        </div>
    </div>

    <?php if (!empty($resultados)) { ?>
        <div class="card shadow-md">
            <div class="card-body bg-dark text-light">
                <h4 class="card-title mb-4 text-center">Expedientes</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark bg-oscuro text-center">
                            <tr>
                                <th>Número</th><th>Año</th><th>Sector</th><th>Tipo</th><th>Estado</th><th>Asunto</th><th>Accion</th> 
                            </tr>
                        </thead>
                        <tbody class="bg-oscuro text-center">
                            <?php foreach($resultados as $exp){ ?>
                                <tr>
                                    <td><?= htmlspecialchars($exp['numero']) ?></td>
                                    <td><?= htmlspecialchars($exp['anio']) ?></td>
                                    <td><?= htmlspecialchars($exp['sector_nombre']) ?></td>
                                    <td><?= htmlspecialchars($exp['tipo_nombre']) ?></td>
                                    <td><?= htmlspecialchars($exp['estado_nombre']) ?></td>
                                    <td><?= htmlspecialchars($exp['asunto']) ?></td>
                                        <div class="btn-group" role="group"><td>
                                            <a href="./ver_expediente.php?id=<?= htmlspecialchars($exp['id']) ?>" class="btn btn-sm btn-light">Ver</a>
                                            <a href="./editar_expediente.php?id=<?= htmlspecialchars($exp['id']) ?>" class="btn btn-sm btn-secondary">Editar</a>
                                            <a type="button" class="btn btn-sm btn-danger">Eliminar</a></td>
                                        </div>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><br>
</div>
<?php } ?>
