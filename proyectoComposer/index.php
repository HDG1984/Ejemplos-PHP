<?php
include __DIR__.'/etc/conf.php';
require_once __DIR__.'/src/conn.php';
require_once __DIR__.'/etc/dbfuncs.php';

session_start();

$pdo=connect();
if ($pdo===false) die('No se puede conectar con la base de datos.');

if(isset($_SESSION['usuario'])){
       
    $usercod = $_SESSION['usuario'][0]['cod'];
    $listaPedidos = listaDePedidosPorCliente($pdo,$usercod); 
    
    $tiempoMaxSesion = 120;
    $tiempoSesion = time() - $_SESSION['usuario']['inicio'];
    if($tiempoSesion > $tiempoMaxSesion){
        unset($_SESSION['usuario']);
    }    
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Portal del cliente de WetWater S.L.</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet"  type="text/css">
    <title>Página principal</title>
<body>
    <?php if(!isset($_SESSION['usuario'])): ?>
        <H1>Portal del cliente de WetWater S.L.</H1>
        <br>
        <a href="ej3.php">Consulte nuestra lista de productos.</a>
        <br>
        <p>No se ha autenticado en el portal del cliente de WetWater S.L. o se ha expirado el tiempo de sesión.</p>
        
        <p>Diríjase a la <a href="login.php">página de autentificación.</a></p>
    <?php else: ?>
        <H1>Portal del cliente de WetWater S.L.</H1>
        <A href="ej3.php">Consulte nuestra lista de productos</A>
        <H2>Bienvenido ###### <a href="logout.php" alt="Cerrar Sesión"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        <a href="password.php"><i class="fa-solid fa-user-pen"></i></a>.</H2>
        <P> Haga click en <i class="fa-solid fa-arrow-right-from-bracket"></i> para cerrar sesión.</p>
        <P> Haga click en <i class="fa-solid fa-user-pen"></i> para cambiar su contraseña.</P>
        <P> <B>¡Atención!</B> La sesión expirará en 120 segundos de inactividad.</P>
        <P> A continuación puede ver el listado de sus pedidos. </P>
        
        <table>
            <thead>
                <tr>
                    <th>Codigo de cliente</th>
                    <th>Nombre de cliente</th>
                    <th>ID de pedido</th>
                    <th>Fecha del pedido</th>
                    <th>Fecha de entrega</th>
                </tr>
            </thead>
            <?php foreach($listaPedidos as $pedido): ?>
                <tr>
                    <td><?=$pedido['codigousuario'];?></td>
                    <td><?=$pedido['nombreusuario'];?></td>
                    <td><?=$pedido['idpedido'];?></td>
                    <td><?=$pedido['fechapedido'];?></td>
                    <td><?=$pedido['fechaentrega'];?></td>
                </tr>
            <?php endforeach;?>
        </table>
    <?php endif; ?>
</body>
</html>