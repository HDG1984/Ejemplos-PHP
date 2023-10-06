<?php
require_once __DIR__.'/etc/conf.php';
require_once __DIR__.'/src/conn.php';
require_once __DIR__.'/src/dbfuncs.php';

$idpedido=filter_input(INPUT_POST,'idpedido',FILTER_VALIDATE_INT);
$usercod=filter_input(INPUT_POST,'usercod');
$idproducto=filter_input(INPUT_POST,'idproducto',FILTER_VALIDATE_INT);
$unidades=filter_input(INPUT_POST,'unidades',FILTER_VALIDATE_INT);
$idLineaPedido=filter_input(INPUT_POST,'idLineaPedido',FILTER_VALIDATE_INT);
$errors=[];
$resultados=[];
if ($idpedido!==null && $idpedido!==false){
    $pdo=connect();
    if($pdo===false) die('No se puede conectar con la base de datos.'); 
   
    if(isset($idproducto) && isset($unidades)){
        $nuevaLineaPedido= nuevaLineaPedido($pdo, $idpedido, $idproducto, $unidades);
        if ($nuevaLineaPedido===-1 || $nuevaLineaPedido=== -2){
            $errors[]="No se ha podido realizar la operación, no queda stock o el producto no existe.";
        }
    }
    
    if(isset($idLineaPedido)){
        $borrarLineaPedido= borrarLineaPedido($pdo, $idLineaPedido);
        if ($borrarLineaPedido===-1 || $borrarLineaPedido=== false){
            $errors[]="No se ha podido borrar la línea de pedido.";
        }
    }
    
    $lineasPedido=obtenerLineasPedido($pdo, $idpedido);
    if ($lineasPedido===-1 || $lineasPedido===false){
        $errors[]="No se ha podido realizar la operación.";
    }
    
    $totalProductos=listaDeProductos($pdo);
    if ($totalProductos===-1 || $totalProductos===false){
        $errors[]="No se ha podido realizar la operación.";
    }
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lineas del pedido</title>
    <style>
        table {font-family: helvetica; border-spacing:0px;width:100%}
        td, th {border:  1px solid;
              padding: 10px;      
              background: white;
              box-sizing: border-box;
              text-align: left;
        }

        thead th {
          background: hsl(20, 50%, 70%);
        }

        .td2{
            background: hsl(20, 50%, 70%);
        }
    </style>
</head>
<body>
    <?php include __DIR__.'/extra/errors.php'; ?>
    <?php
    $total=0;
    foreach ($lineasPedido as $lineaPedido){
        $total+=($lineaPedido['precio'] * $lineaPedido['unidades']);
    }
    $totalIVA = number_format(($total*0.21)+$total,2);
    ?>
    <h3>Editando el pedido <?= $idpedido ?></h3>
    <table>
        <thead>
            <tr>
                <th>Cod. Producto</th>
                <th>Descripción</th>
                <th>Precio unidad</th>
                <th>unidades</th>
                <th>Coste</th>
            </tr>
        </thead>
        <?php foreach ($lineasPedido as $lineaPedido): ?>
        <tr>
            <td><?= $lineaPedido['codprod']; ?>
            <form action="editarpedido.php" method="post">
                <input type="hidden" name="idpedido" value="<?=$idpedido ?>">
                <input type="hidden" name="usercod" value="<?=$usercod?>">
                <input type="hidden" name="idLineaPedido" value="<?=$lineaPedido['idlineapedido']?>">
                <input type="submit" value="Eliminar">
            </form>
            </td>
            <td><?= $lineaPedido['descripcion']; ?></td>
            <td><?= $lineaPedido['precio']; ?></td>
            <td><?= $lineaPedido['unidades']; ?></td>
            <td><?= ($lineaPedido['precio'] * $lineaPedido['unidades']); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" class="td2">Total:</td>
            <td class="td2"><?= $total ?></td>
        </tr>
         <tr>
            <td colspan="4" class="td2">Iva:</td>
            <td class="td2">21%</td>
        </tr>
         <tr>
            <td colspan="4" class="td2">Total con IVA:</td>
            <td class="td2"><?= $totalIVA ?></td>
        </tr>
    </table>
    <br>
    <form action="editarpedido.php" method="POST">
        <label>Productos:</label>
        <select name="idproducto">
            <?php foreach ($totalProductos as $valor): ?>
            <option value="<?= $valor['id'] ?>"><?= $valor['cod'] . ' - ' . $valor['desc'] . ' -- Stock: ' . $valor['stock'] ?></option>
            <?php endforeach; ?>
        </select>
        <label>Unidades:</label>
        <input type="hidden" name="idpedido" value="<?= $idpedido ?>">
        <input type="hidden" name="usercod" value="<?= $usercod ?>">
        <input name="unidades" type="text"></input>
        <input type="submit" value="Añadir!">
    </form>
    <form action="pedidos.php" method="post">
        <input type="submit" value="Volver a la lista de pedidos">
        <?php if ($usercod): ?>
            <input type="hidden" name="usercod" value="<?=$usercod?>">
        <?php endif; ?>
    </form>
</body>
</html>


