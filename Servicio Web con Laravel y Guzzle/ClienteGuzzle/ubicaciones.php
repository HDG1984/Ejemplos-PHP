<?php

require_once __DIR__. '/vendor/autoload.php';

$client = new GuzzleHttp\Client(['http_errors'=>false]);

$response = $client->request('GET', 'http://localhost:80/dwes05/public/api/ubicaciones');

$json = $response->getBody()->getContents();

$ubicaciones = json_decode($json, true);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo/estilo.css">
    <title>Ubicaciones</title>
</head>
<body>
    <?php if($ubicaciones): ?>
        <h2>Ubicaciones</h2>
        <table >
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Días</th>
            </tr>
            <?php foreach($ubicaciones as $ubicacion): ?>
                <tr>
                    <td><?= $ubicacion['id'] ?></td>
                    <td><?= $ubicacion['nombre'] ?></td>
                    <td><?= $ubicacion['descripcion'] ?></td>
                    <td><?= $ubicacion['dias'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <h3 class="error">No se encontraron ubicaciones.</h3>
    <?php endif ?>
</body>
</html>



