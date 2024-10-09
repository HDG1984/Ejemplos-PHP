<?php
require_once __DIR__. '/vendor/autoload.php';

$idTaller=filter_input(INPUT_POST,'id_taller',FILTER_VALIDATE_INT);
$idUbicacion=filter_input(INPUT_POST,'id_ubicacion',FILTER_VALIDATE_INT);

if(!$idTaller && isset($idTaller)){
    echo '<h3 class="error">Error: el campo Id de taller es obligatorio.</h3>';
}

if(!$idUbicacion && isset($idUbicacion)){
    echo '<h3 class="error">Error: el campo Id de nueva ubicación es obligatorio.</h3>';
}

$client = new GuzzleHttp\Client(['http_errors'=>false]);

$response = $client->request('PATCH', 'http://localhost:80/dwes05/public/api/talleres/'. $idTaller . '/cambiarubicacion',
    [
        'json'=>['id_nueva_ubicacion'=>$idUbicacion]
    ]
);

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
    <title>Cambiar ubicación de taller</title>
</head>
<body>

    <?php if($datos !== null): ?>
        <?php if($status === 200): ?>
            <h2 class="correcto"><?= $datos['resultado'] ?></h2>
        <?php elseif($status): ?>
            <h2 class="error">Error:</h2>
            <?php foreach($datos as $dato): ?>
                <h2><?= $dato ?> (<?= $status ?>)</h2><br>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(!isset($idTaller)): ?>
    <h2 class="titulo_formulario">Cambiar ubicación de taller</h2>
    <form action="" method="POST" class="formulario">
        <label for="id">Id de taller:</label><br>
        <input type="text" id="id" name="id_taller"><br><br>

        <label for="id_ub">Id de nueva ubicación:</label><br>
        <input type="text" id="id_ub" name="id_ubicacion"><br><br>

        <input type="submit" value="Cambiar ubicación">
    </form>
    <?php endif; ?>
</body>
</html>