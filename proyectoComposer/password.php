<?php
include __DIR__.'/etc/conf.php';
require_once __DIR__.'/src/conn.php';
require_once __DIR__.'/etc/dbfuncs.php';
require_once __DIR__.'/vendor/autoload.php';

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

$log = new Logger('Eventos de usuario');
$log->pushHandler(new StreamHandler(__DIR__.'/eventos.log', Logger::DEBUG));

$passAntiguo=filter_input(INPUT_POST,'passAntiguo',FILTER_SANITIZE_STRING);
$passNuevo=filter_input(INPUT_POST,'passNuevo',FILTER_SANITIZE_STRING);
$passNuevoRep=filter_input(INPUT_POST,'passNuevoRep',FILTER_SANITIZE_STRING);
$errors=[];
$mensajes=[];
//password = test
//nueva password = nuevo
session_start();
if(isset($_SESSION['usuario'])){
    $pdo=connect();
    if ($pdo===false) die('No se puede conectar con la base de datos.');
    
    $usercod=$_SESSION['usuario'][0]['cod'];
    $userId=$_SESSION['usuario'][0]['id'];
    
    if(isset($_POST['passAntiguo'])){
        $cambioPass= CambioPasswordCliente($pdo, $passAntiguo, $passNuevo, $passNuevoRep, $usercod, $userId);
    
        if($cambioPass == false || $cambioPass == -1 || $cambioPass == 0){
            $errors[]='¡¡La contraseña actual no es correcta!!';
        }elseif($cambioPass == -2){
            $errors[]='¡¡La nueva password no es igual a la password repetida!!';
        }else{
            $mensajes[]='Se ha modificado su contraseña';
            $log->info('El usuario ' . $usercod . ' ha cambiado su password');
        }
    }
    
    $tiempoMaxSesion = 120;
    $tiempoSesion = time() - $_SESSION['usuario']['inicio'];
    if($tiempoSesion > $tiempoMaxSesion){
        unset($_SESSION['usuario']);
    }
    
}else{
    header('location: login.php');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar password</title>
</head>
<body>
    <?php include __DIR__.'/extra/errors.php'; ?>
    <?php include __DIR__.'/extra/mensajes.php'; ?>
    <?php if(isset($_SESSION['usuario'])): ?>
        <p>Bienvenido, <?=$_SESSION['usuario'][0]['nombre']?>.</p>
        <p>En esta página puede cambiar su contraseña. Vaya a la <a href="index.php">Página principal</a> para ver sus pedidos</p>
        <form action="password.php" method="post">
            <p>Password antiguo: <input type="password" name="passAntiguo"></p>
            <p>Password nuevo: <input type="password" name="passNuevo"></p>
            <p>Repetición password nuevo: <input type="password" name="passNuevoRep"></p>
            <input type="submit" value="Enviar¡">
        </form>
    <?php endif; ?>
</body>
</html>
