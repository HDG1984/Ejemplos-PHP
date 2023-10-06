<?php

include_once 'lib/fpedidos.php';
include_once 'etc/conf.php';

if($_POST){

    $pedido=[];
    $errores=[];

    if(isset($_POST['cliente']) && preg_match('/^([PEI][0-9]{5})/', $_POST['cliente'])){
        $pedido['cliente'] = strtoupper($_POST['cliente']);
    }else{
        $errores[] = 'El código cliente no es correcto.';
    }
    
    if(isset($_POST['fecha']) && preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $_POST['fecha'])){

        date_default_timezone_set('Europe/Madrid');
        
        $fechaHoy = date("d/m/Y");
        $fechaPedido = date($_POST['fecha']);
        
        $valoresPrimera = explode ("/", $fechaHoy);   
        $valoresSegunda = explode ("/", $fechaPedido); 

        $diaPrimera    = $valoresPrimera[0];  
        $mesPrimera  = $valoresPrimera[1];  
        $anyoPrimera   = $valoresPrimera[2]; 

        $diaSegunda   = $valoresSegunda[0];  
        $mesSegunda = $valoresSegunda[1];  
        $anyoSegunda  = $valoresSegunda[2];
        
        $diasPrimeraFecha = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
        $diasSegundaFecha = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);
        
        if(checkdate($mesSegunda, $diaSegunda, $anyoSegunda) && $diasPrimeraFecha < $diasSegundaFecha){ 
            $pedido['fecha'] = $_POST['fecha'];
        }else{    
            $errores[]='La fecha tiene que ser válida y posterior al día de hoy';
        }
    }else{
        $errores[] = 'La fecha no tiene el formato correcto o no existe';
    }

    if(isset($_POST['producto']) && isset($_POST['unidades']) 
            && is_array($_POST['producto']) && is_array($_POST['unidades']) && count($_POST['producto'])== count($_POST['unidades'])){
        for($i=0; $i<10; $i++){
            if(existeProducto($_POST['producto'][$i], $productos) && $_POST['unidades'][$i] >0 && $_POST['producto'][$i] != 'NULL'){
                $lineaPedido = ['producto' => $_POST['producto'][$i], 'unidades' => $_POST['unidades'][$i]];
                $pedido['productos'][]= $lineaPedido;
            }else{
                if(!existeProducto($_POST['producto'][$i], $productos) && $_POST['producto'][$i] != 'NULL'){
                    $errores[] = "El producto " . $_POST['producto'][$i] . " no existe";
                }    
                if($_POST['unidades'][$i] <1 && $_POST['producto'][$i] != 'NULL'){
                    $errores[] = "El número de unidades para el producto " . $_POST['producto'][$i] . " no es correcto.";
                }   
            }  
        } 

    }
 
}
if(isset($errores) && !$errores && isset($pedido['productos'])){    
    include_once 'factura.php';   
}else     
    include_once 'formulario.php';  
?>

