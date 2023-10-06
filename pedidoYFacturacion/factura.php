<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS.css?<?php echo date('Y-m-d H:i:s'); ?>">
    <title>Factura proforma</title>
</head>
<body>
    <?php

    $total = costePedido($pedido, $productos);
    $totalIVA = number_format(($total*0.21)+$total,2);
    
    ?>
    <h4 class="h4C">Cliente: <?= $pedido['cliente'] ?></h4>
    <h4 class="h4F">Fecha de entrega: <?= $pedido['fecha'] ?></h4>
    <table class="tFactura">
        <tr>
            <th class="thf">Cod</th>
            <th class="thf">Descripción</th>
            <th class="thf">Precio unidad</th>
            <th class="thf">Coste unidad</th>
            <th class="thf">Precio</th>
        </tr>
        <?php foreach ($pedido['productos'] as $k => $lineaPedido): ?>
        <tr>
            <td class="td1"><?= $lineaPedido['producto']; ?></td>
            <td class="td1"><?= $lineaPedido['unidades']; ?></td>
            <td class="td1"><?= $lineaPedido['precio_unidad']; ?></td>
            <td class="td1"><?= $lineaPedido['descripcion']; ?></td>
            <td class="td1"><?= $lineaPedido['coste_linea']; ?></td>
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
    <a class="aVolver" href="?comercial=http://localhost/dwes01/pedido.php">Hacer nuevo pedido</a>
</body>
</html>


