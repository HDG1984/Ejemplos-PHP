<?php

include __DIR__.'/etc/conf.php';
require_once __DIR__.'/src/conn.php';
require_once __DIR__.'/etc/dbfuncs.php';
require_once __DIR__.'/vendor/autoload.php';

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

$log = new Logger('Eventos de usuario');
$log->pushHandler(new StreamHandler(__DIR__.'/eventos.log', Logger::DEBUG));

$usercod=filter_input(INPUT_POST,'nombreUsuario',FILTER_SANITIZE_STRING);
$userPass=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
$errors=[];

session_start();
if(!isset($_SESSION['usuario'])){

    $pdo=connect();
    if ($pdo===false) die('No se puede conectar con la base de datos.');
 
    $usuarioCorrecto = verificarUsuario($pdo, $usercod, $userPass);
    
    if(is_array($usuarioCorrecto)){
        $log->info('El usuario ' . $usercod . ' se ha autenticado');
        $_SESSION['usuario']=$usuarioCorrecto;
        $_SESSION['usuario']['inicio']=time();
    }elseif(isset ($_POST['nombreUsuario']) && isset ($_POST['password'])){
        $errors[]='No se ha podido verificar la contraseña o el usuario.';
        $log->error( $usercod . ' ha intentado realizar una autenticación sin éxito');
    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario login</title>
</head>
<body>
<?php include __DIR__.'/extra/errors.php'; ?>
<?php include __DIR__.'/extra/resultados.php'; ?>
    <?php if(!isset($_SESSION['usuario'])): ?>
        <h2>Formulario de login</h2>
        <form action="login.php" method="post">
            <p>Código de usuario: <input type="text" name="nombreUsuario"></p>
            <p>Password:<input type="password" name="password"></p>
            <input type="submit" value="!Entrar¡">
        </form>
    <?php else: ?>
        
        <p>Bienvenido, <?=$_SESSION['usuario'][0]['nombre']?>. Vaya a la <a href="index.php">Página principal</a> para ver sus pedidos</p>
        
    <?php endif; ?>
</body>
</html>