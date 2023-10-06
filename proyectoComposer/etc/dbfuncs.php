<?php

function verificarUsuario(PDO $pdo, $usercod, $userPass) {
    $passHash = hash('sha256', $usercod . $userPass);
    $sql='SELECT id, cod, nombre FROM usuarios WHERE cod = :usercod AND password = :passhash';
    $ret=false;
    try{
        $stmt = $pdo->prepare($sql);
        $data=['usercod'=>$usercod,'passhash'=>$passHash];
        $stmt->execute($data);
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
/*
function CambioPasswordCliente(PDO $pdo, $passAntiguo, $passNuevo, $passNuevoRep, $usercod ){
    $sql='SELECT password FROM usuarios WHERE cod = :usercod';
         
    $ret=false;
    try {
        $stmt = $pdo->prepare($sql);
        $data=['usercod'=>$usercod];
        if ($stmt->execute($data)) {
                $passwordBD=$stmt->fetchAll(PDO::FETCH_ASSOC); 
                $passwordAntiguoHash = hash('sha256', $usercod . $passAntiguo);
                if($passwordBD[0]['password'] === $passwordAntiguoHash && $passNuevo === $passNuevoRep){
                    $sql='UPDATE pedidos SET fechaentrega=:fechaentrega WHERE id=:idpedido';
                    
                    try {
                        $stmt=$pdo->prepare($sql);
                        $data=['fechaentrega'=>$nuevafechaentrega,'idpedido'=>$idpedido];
                        if ($stmt->execute($data)) {
                                $ret=$stmt->rowCount(); 
                        }
                    } catch (PDOException $ex) {
                        $ret=-1;
                    }
                }
        } 
    } catch (PDOException $ex) {
        $ret=-1;
    } 
    return $ret;
}
 * 
 */
function CambioPasswordCliente(PDO $pdo, $passAntiguo, $passNuevo, $passNuevoRep, $usercod, $userId ){
    if($passNuevo === $passNuevoRep){
        $hashPassNueva = hash('sha256', $usercod . $passNuevo);
        $hashPassAntigua = hash('sha256', $usercod . $passAntiguo);
        $sql='UPDATE usuarios SET password=:hashPassNueva WHERE id=:userId AND password=:hashPassAntigua';
        $ret=false;
        try {
            $stmt=$pdo->prepare($sql);
            $data=['hashPassNueva'=>$hashPassNueva,'userId'=>$userId, 'hashPassAntigua'=>$hashPassAntigua];
            if ($stmt->execute($data)) {
                    $ret=$stmt->rowCount(); 
            }
        } catch (PDOException $ex) {
            $ret=-1;
        }
    }else{
        $ret=-2;
    }
    return $ret;
}

