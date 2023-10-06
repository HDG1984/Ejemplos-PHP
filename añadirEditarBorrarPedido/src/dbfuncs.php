<?php

function listaDeProductos(PDO $pdo) {
    $sql='SELECT productos.id, cod, productos.desc, stock FROM productos';
    $ret=false;
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $ret=$stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $ex) {
        $ret=-1;
    }
    return $ret;
}

function listaDePedidosPorCliente(PDO $pdo, $codcliente) {
    $sql='SELECT pedidos.id as idpedido, pedidos.fechapedido as fechapedido,'
         .' pedidos.fechaentrega as fechaentrega, pedidos.idusuario as idusuario,'
         .' usuarios.cod as codigousuario, usuarios.nombre as nombreusuario '
         .' FROM pedidos left join usuarios on usuarios.id=pedidos.idusuario '
         .' WHERE usuarios.cod=:codcliente';
         $ret=false;
         try {
             $stmt = $pdo->prepare($sql);
             $data=['codcliente'=>$codcliente];
             if ($stmt->execute($data)) {
                     $ret=$stmt->fetchAll(PDO::FETCH_ASSOC);                       
             } 
         } catch (PDOException $ex) {
             $ret=-1;
         } 
         return $ret;
}

function nuevoPedido (PDO $pdo, $codcliente, $fechaentrega)
{
    $sql='insert into pedidos (fechaentrega,idusuario) values (:fechaentrega,(select id from usuarios where cod=:codcliente))';
    $ret=false;
    try {
        $stmt = $pdo->prepare($sql);
        $data=['fechaentrega'=>$fechaentrega,'codcliente'=>$codcliente];
        if ($stmt->execute($data)) {
                $ret=$stmt->rowCount(); 
        } 
    } catch (PDOException $ex) {
        $ret=-1;
    } 
    return $ret;        
}

function borrarLineaPedido (PDO $pdo, $idLineaPedido) {
    //1º incrementa el stock
    $sql='update productos set stock=stock+(select unidades from lineaspedido where id=:idlineapedido) where id=(select productos_id from lineaspedido where id=:idlineapedido)';
    $ret=false;
    try {
        $stmt = $pdo->prepare($sql);
        $data=['idlineapedido'=>$idLineaPedido];
        if ($stmt->execute($data)) {
                $ret=$stmt->rowCount(); 
        } 
    } catch (PDOException $ex) {
        $ret=-1;
    } 
    //2º borra la linea de pedido
    $sql='DELETE FROM lineaspedido WHERE id=:idlineapedido';
    try {
        $stmt = $pdo->prepare($sql);
        $data=['idlineapedido'=>$idLineaPedido];
        if ($stmt->execute($data)) {
                $ret=$stmt->rowCount(); 
        } 
    } catch (PDOException $ex) {
        $ret=-1;
    } 
    return $ret;
}

function borrarPedido(PDO $pdo, $idpedido)
{
    //1º Obtener las lineas de pedido
    $sql='SELECT id from lineaspedido where pedidos_id=:idpedido';
    $ret=false;
    try {
        $stmt = $pdo->prepare($sql);
        $data=['idpedido'=>$idpedido];
        if ($stmt->execute($data)) {
                $arrayIdLineaPedido=$stmt->fetchAll(PDO::FETCH_ASSOC);                       
        } 
    } catch (PDOException $ex) {
        $ret=-1;
    } 
    //2º Borra cada linea de pedido invocando borrarLineaPedido
    foreach ($arrayIdLineaPedido as $id){
        borrarLineaPedido($pdo, $id['id']);
    }
    //3º Borra el pedido
    $sql='DELETE FROM pedidos WHERE id=:idpedido';
    try {
        $stmt = $pdo->prepare($sql);
        $data=['idpedido'=>$idpedido];
        if ($stmt->execute($data)) {
                $ret=$stmt->rowCount(); 
        } 
    } catch (PDOException $ex) {
        $ret=-1;
    }
    return $ret;
}

function modificarFechaEntregaPedido(PDO $pdo, $idpedido, $nuevafechaentrega)
{
    $sql='UPDATE pedidos SET fechaentrega=:fechaentrega WHERE id=:idpedido';
    $ret=false;
    try {
        $stmt=$pdo->prepare($sql);
        $data=['fechaentrega'=>$nuevafechaentrega,'idpedido'=>$idpedido];
        if ($stmt->execute($data)) {
                $ret=$stmt->rowCount(); 
        }
    } catch (PDOException $ex) {
        $ret=-1;
    }
    return $ret;
}

function obtenerLineasPedido(PDO $pdo, $idpedido)
{    
    $sql='SELECT lineaspedido.id as idlineapedido, lineaspedido.codprod as codprod,
          lineaspedido.unidades as unidades, lineaspedido.precio as precio,
          productos.desc as descripcion
          from lineaspedido left join productos on lineaspedido.productos_id=productos.id where pedidos_id=:idpedido';
        $ret=false;
        try {
            $stmt = $pdo->prepare($sql);
            $data=['idpedido'=>$idpedido];
            if ($stmt->execute($data)) {
                    $ret=$stmt->fetchAll(PDO::FETCH_ASSOC);                       
            } 
        } catch (PDOException $ex) {
            $ret=-1;
        } 
    return $ret; 
}

function nuevaLineaPedido(PDO $pdo, $idpedido, $idproducto, $unidades)
{   
    //1º Inicia transacción
    $pdo->beginTransaction();
    //2º Actualiza el stock
    $sql='update productos set stock=stock-:unidades where id=:idproducto and stock>=:unidades';
    $ret=true;
    try{
        $stmt=$pdo->prepare($sql);
        $data=['unidades'=>$unidades,'idproducto'=>$idproducto];
        $stmt->execute($data);
        //3º Si las filas modificadas (rowCount) es 0, entonces haz un rollBack y termina.
        //   Si las filas modificadas (rowCount) es 1, entonces continua
      
    } catch (PDOException $ex){
        $ret=-2;
    }
    if($stmt->rowCount()==0){   
          $pdo->rollBack();
          return -1;
    }
    //4º Inserta la línea de pedido    
    $sql='insert into lineaspedido (unidades, pedidos_id, productos_id, codprod, precio)
    select :unidades,:idpedido,id,cod,precio from productos where id=:idproducto'; 
    try {
        $stmt=$pdo->prepare($sql);
        $data=['unidades'=>$unidades, 'idpedido'=>$idpedido, 'idproducto'=>$idproducto];
        $stmt->execute($data);
    } catch (PDOException $ex) {
        $ret=-2;
    }
    //5º Si la inserción fue bien (rowCount es 1), entonces haz commit, sino rollback
    
    if($stmt->rowCount()==0){  
          $pdo->rollBack();
          return -1;
    }else{
        $pdo->commit();
    } 
  
    return $ret;
}

