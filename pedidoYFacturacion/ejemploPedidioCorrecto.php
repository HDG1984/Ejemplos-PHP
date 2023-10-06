<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Correcto</title>
</head>

<body>
    <?php

    include 'etc/conf.php';

    include_once 'lib/fpedidos.php'; 
    
    $pedido['productos'][0]['producto']='H01';
    $pedido['productos'][0]['unidades']=10;
    $pedido['productos'][1]['producto']='H03';
    $pedido['productos'][1]['unidades']=8;
    $pedido['productos'][2]['producto']='A02';
    $pedido['productos'][2]['unidades']=15;
    $pedido['productos'][3]['producto']='A03';
    $pedido['productos'][3]['unidades']=8;
    $pedido['productos'][4]['producto']='A04';
    $pedido['productos'][4]['unidades']=10;
    $pedido['productos'][1]['producto']='G02';
    $pedido['productos'][1]['unidades']=20;

    $total = costePedido($pedido, $productos);
   
    ?>
    <h3>Coste del pedido: <?= $total . '€' ?></h3>
    <ul>
    <?php foreach ($pedido['productos'] as $k => $v): ?>
        <li>Código: <?= $v['producto']; ?></li>
        <ul>
            <li><?= $v['descripcion']; ?></li>
            <li>Unidades: <?= $v['unidades']; ?></li>
            <li>Coste línea pedido: <?= $v['unidades'] . '*' . $v['precio_unidad'] . '€ = ' . costLineaPedido($v['producto'], $v['unidades'], $productos) . '€'; ?></li>
        </ul>
    <?php endforeach; ?>
        
    </ul>
</body>
</html>
