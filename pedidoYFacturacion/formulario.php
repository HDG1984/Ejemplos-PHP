
<?php
if(isset($errores)){
    echo '<h4>Errores:</h4>';
    if(!isset($pedido['productos'])){
        echo 'Tienes que seleccionar algún producto!!!!.';
    }
    foreach ($errores as $error){
        echo '<ul>';
            echo '<li>';
            echo $error??'';
            echo '</li>';
        echo '</ul>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario pedidos</title>
    <link rel="stylesheet" href="CSS.css">
</head>

<body>
    
    <form action="pedido.php" method="POST">
        <fieldset>
            <legend>Datos cliente:</legend>
            <p>Número de cliente: <input type="text" name="cliente" value="<?= $pedido['cliente']??'' ?>"> Fecha de entrega: <input type="text" name="fecha" value="<?= $pedido['fecha']??'' ?>"></p>
        </fieldset>
        <fieldset>
            <legend>Datos pedido:</legend>
            <p><label class="label1">Producto</label><label class="label2">Unidades</label><br>    
            <?php
            for($i=0;$i<10;$i++){
                if(isset($pedido) && isset($pedido['productos'][$i])){
                    $codProducto = $pedido['productos'][$i]['producto'];
                    $uniProducto = $pedido['productos'][$i]['unidades'];
                }else{
                    $codProducto = "";
                    $uniProducto = "";
                }
            ?>
            <select name="producto[]" value="">
                <option value="NULL"></option>
                <option value="001">Producto no existente(TEST)</option>
                <?php foreach ($productos as $k => $v):
                    $selected = '';
                    if($k==$codProducto) $selected='selected';
                    ?>
                    <option value="<?= $k ?>" <?= $selected ?>><?= $v['descripcion'] . ' [' . $v['precio_unidad'] . '€]' ?></option>
                <?php endforeach; ?>
            </select>&nbsp;
            <input type="text" name="unidades[]" value="<?= $uniProducto ?>"></p>    
            <?php } ?>
            
        </fieldset>
        <fieldset>
            <p class="posicionBoton"><input type="submit" value="!Enviar pedido¡">&nbsp;<input type="reset" value="Resetear formulario"></p>
                
        </fieldset>
    </form>
</body>
</html>