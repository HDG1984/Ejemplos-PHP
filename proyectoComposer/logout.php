<?php

require_once __DIR__.'/vendor/autoload.php';

use \Monolog\Logger;

use \Monolog\Handler\StreamHandler;

$log = new Logger('Eventos de usuario');
$log->pushHandler(new StreamHandler(__DIR__.'/eventos.log', Logger::DEBUG));

session_start();
   
if (!isset($_SESSION['usuario'])) {
    echo 'No se puede cerrar la sesión, dado que no la ha iniciado. <br><br>';
    echo '<a href="login.php">Volver a la página principal del portal de cliente de WeltWater S.L.</a>';
}else{
    $log->info('El usuario ' . $_SESSION['usuario'][0]['cod'] . ' ha cerrado la sesión.');
    echo 'Hasta otra ' . $_SESSION['usuario'][0]['nombre'] . '. La sesión se ha cerrado <br><br>';
    echo '<a href="login.php">Volver a la página principal del portal de cliente de WeltWater S.L.</a>';
    unset($_SESSION['usuario']);
}

