<?php

require_once __DIR__.'/etc/conf.php';
require_once __DIR__.'/src/conn.php';
require_once __DIR__.'/src/dbfuncs.php';

$idpedido=filter_input(INPUT_POST,'idpedido',FILTER_VALIDATE_INT);
$usercod=filter_input(INPUT_POST,'usercod');
$confirmacion=filter_input(INPUT_POST,'confirmacion',FILTER_SANITIZE_STRING);
$noConfirmacion=filter_input(INPUT_POST,'noConfirmacion',FILTER_SANITIZE_STRING);
$errors=[];
$resultados=[];

if(isset($noConfirmacion)){
    $pdo=connect();
    if($pdo===false) die('No se puede conectar con la base de datos.');
    
    if(!empty($confirmacion)){
     
        $pedidoBorrado=borrarPedido($pdo, $idpedido);
        if($pedidoBorrado ===-1 || $pedidoBorrado === false){
            $errors[]="Fallo al borrar el pedido.";
        }else{
            $resultados[]= "Operación realizada: se ha borrado el pedido";
        }
         
    }else{
        $errors[]="Para poder borrar el pedido debe marcar la casilla de confirmación.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar pedido</title>
    </head>
<body>   
<?php include __DIR__.'/extra/errors.php'; ?>
<?php include __DIR__.'/extra/resultados.php'; ?>
    <?php if(empty($resultados)):?>
    <h2>Seguro que desea borrar el pedido: <?= $idpedido ?></h2>
    <form action="borrarpedido.php" method="post">
        <p>Confirmo borrar pedido:<input type="checkbox" name="confirmacion" value="ok"></p>
        <input type="hidden" name="noConfirmacion" value="no">
        <input type="hidden" name="usercod" value="<?=$usercod?>">
        <input type="hidden" name="idpedido" value="<?=$idpedido?>">
        <input type="submit" value="Borrar pedido">
    </form>
    <?php endif; ?>
    <br>
    <form action="pedidos.php" method="post">
        <input type="submit" value="Volver a la lista de pedidos">
        <?php if ($usercod): ?>
            <input type="hidden" name="usercod" value="<?=$usercod?>">
        <?php endif; ?>
    </form>
</body>
</html>