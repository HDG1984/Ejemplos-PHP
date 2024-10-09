<?php
require_once __DIR__. '/vendor/autoload.php';

$idTaller=filter_input(INPUT_POST,'id_taller',FILTER_VALIDATE_INT);

if(!$idTaller && isset($idTaller)){
    echo '<h3 class="error">Error: el campo Id del taller es obligatorio.</h3>';
}

$client = new GuzzleHttp\Client(['http_errors'=>false]);

$response = $client->request('DELETE', 'http://localhost:80/dwes05/public/api/talleres/'. $idTaller);

$status=$response->getStatusCode();

$json = $response->getBody()->getContents();

$datos = json_decode($json, true);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo/estilo.css">
    <title>Borrar taller</title>
</head>
<body>
    <?php if($datos !== null): ?>
        <?php if($status === 200): ?>
            <h2 class="correcto"><?= $datos['resultado'] ?></h2>
        <?php elseif($status === 404): ?>
            <h2 class="error">Error:</h2>
            <h2><?= $datos['resultado'] ?> (<?= $status ?>)</h2>
        <?php endif; ?>
    <?php endif; ?>
    <?php if(!isset($idTaller)): ?>
        <h2 class="titulo_formulario">Borrar Taller</h2>
        <form action="" method="POST" class="formulario">
            <label for="id">Id del taller:</label><br>
            <input type="text" id="id" name="id_taller"><br><br>

            <input type="submit" value="Borrar Taller">
        </form>
    <?php endif; ?>
</body>
</html>
