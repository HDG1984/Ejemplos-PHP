<?php

require_once __DIR__. '/vendor/autoload.php';

$nombre = filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_SPECIAL_CHARS);
$descripcion = filter_input(INPUT_POST,'descripcion',FILTER_SANITIZE_SPECIAL_CHARS);
$diaSemana = filter_input(INPUT_POST,'dia_semana',FILTER_SANITIZE_SPECIAL_CHARS);
$horaInicio = filter_input(INPUT_POST,'hora_inicio',FILTER_SANITIZE_SPECIAL_CHARS);
$horaFin = filter_input(INPUT_POST,'hora_fin',FILTER_SANITIZE_SPECIAL_CHARS);
$ubicacionId=filter_input(INPUT_POST,'ubicacion_id',FILTER_VALIDATE_INT);
$cupoMaximo=filter_input(INPUT_POST,'cupo_maximo',FILTER_VALIDATE_INT);

$client = new GuzzleHttp\Client(['http_errors'=>false]);

$response = $client->request('POST', 'http://localhost:80/dwes05/public/api/ubicaciones/'. $ubicacionId .'/creartaller', [
    'form_params' => [
        'nombre'=>$nombre,
        'descripcion'=>$descripcion,
        'dia_semana'=>$diaSemana,
        'hora_inicio'=>$horaInicio,
        'hora_fin'=>$horaFin,
        'cupo_maximo'=>$cupoMaximo
    ]
]);

$status = $response->getStatusCode();
$json = $response->getBody()->getContents();
$datos = json_decode($json, true);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo/estilo.css">
    <title>Crear nuevo taller</title>
</head>
<body>
    <?php if($status === 200): ?>
        <h2 class="correcto">Taller <?=$nombre?> insertado correctamente</h2>
    <?php endif; ?>
    <?php if($status === 422): ?>
        <h2 class="error">(<?= $status ?>) Error al insertar el taller:</h2>
        <ul>
            <?php foreach($datos['errores'] as $campo => $errores): ?>
                <ul>
                    <?php foreach($errores as $error): ?>
                        <li ><?= $error ?> </li><br>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if($status === 404): ?>
        <h3 class="error">Error: el id: <?=$ubicacionId?> no existe. (<?= $status ?>)</h3>
    <?php endif; ?>
</body>
</html>
