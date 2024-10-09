<?php
require_once __DIR__. '/vendor/autoload.php';

if(isset($_GET['ubicacion']) && !empty($_GET['ubicacion'])){
    $ubicacion = $_GET['ubicacion'];


$client = new GuzzleHttp\Client(['http_errors'=>false]);

$response = $client->request('GET', 'http://localhost:80/dwes05/public/api/ubicaciones/'. $ubicacion .'/talleres');

$status=$response->getStatusCode();

$json = $response->getBody()->getContents();

$talleres = json_decode($json, true);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo/estilo.css">
    <title>Talleres por ubicación</title>
</head>
<body>
    <?php if($status === 200): ?>
        <?php if(empty($talleres)): ?>
            <h3 class="error">No hay talleres para esta ubicación.</h3>
        <?php else: ?>
            <h2>Talleres</h2>
            <table >
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Día semana</th>
                <th>Hora inicio</th>
                <th>Hora fin</th>
                <th>Cupo máximo</th>
                <th>Id ubicacion</th>
            </tr>
            <?php foreach($talleres as $taller): ?>
                <tr>
                    <td><?= $taller['nombre'] ?></td>
                    <td><?= $taller['descripcion'] ?></td>
                    <td><?= $taller['dia_semana'] ?></td>
                    <td><?= $taller['hora_inicio'] ?></td>
                    <td><?= $taller['hora_fin'] ?></td>
                    <td><?= $taller['cupo_maximo'] ?></td>
                    <td><?= $taller['ubicacion_id'] ?></td>
                </tr>
            <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($status === 404): ?>
        <h3 class="error">Error: la ubicación no existe.</h3>
    <?php elseif($status !== 200 && $status !== 404): ?>
        <h3 class="error">Error: código <?= $status ?></h3>
    <?php endif; ?>
</body>
</html>

<?php

}else{
    echo '<h3 class="error">No existe el parametro ubicación<h3>';
}

?>