<?php

/**
 * Comprueba si existe un producto.
 * 
 * La función comprueba si el producto existe dentro del array productos.
 * 
 * @param type $codigoProducto Código del producto que hay que comprobar.
 * @param type $arrayProductos Array que contiene la lista de productos con el código a comprobar.
 * @return type boolean Devuelve true si lo encuentra en el array productos o false si no lo encuentra con la función array_key_exists. 
 */

function existeProducto($codigoProducto, $arrayProductos){
   
    return array_key_exists($codigoProducto, $arrayProductos);
}


/**
 * Calcula el coste de una línea de pedido.
 * 
 * La función devuelve el coste de una línea de pedido si la función existeProducto devuelve true y si la cantidad de unidades es mayor de 0.
 * 
 * @param type $codProducto Código del producto a calcular coste.
 * @param type $numUnidades Unidades del producto de una línea de pedido.
 * @param type $arrayProductos Array que contiene la lista de productos con el código a comprobar.
 * @return type double Retorna el coste de una línea de pedido o -1 si el producto no existe o las unidades son 0 o inferior.
 */
function costLineaPedido($codProducto, $numUnidades, $arrayProductos){
    
    if(existeProducto($codProducto, $arrayProductos) && $numUnidades > 0){
        $result = $arrayProductos[$codProducto]['precio_unidad'] * $numUnidades;
    }else{
        $result = -1;
    }
    
    return number_format($result,2);
}


/**
 * Devuelve el coste total del pedido.
 * 
 * La función devuelve el coste de un pedido y añade en el array pedido la descripción, el precio de una unidad y el coste de la línea de pedido
 * comprobando que exista el producto y si la unidad es correcta , en caso contrario elimina dicha línea de producto.
 * 
 * @param type $arrayPedido Array que contiene el pedido completo.
 * @param type $arrayProductos Array que contiene la lista de productos.
 * @return type double Retorna el coste de un pedido que tiene datos válidos.
 */

function costePedido(&$arrayPedido, $arrayProductos){

    $resultado = 0;
    
    foreach ($arrayPedido['productos'] as $k => &$lineaPedido){
        
        $costeLinea = costLineaPedido($lineaPedido['producto'], $lineaPedido['unidades'], $arrayProductos);
        
        if($costeLinea > 0 ){

            $resultado += $costeLinea;

            $lineaPedido['descripcion'] =  $arrayProductos[$lineaPedido['producto']]['descripcion'];
            $lineaPedido['precio_unidad'] =  $arrayProductos[$lineaPedido['producto']]['precio_unidad'];
            $lineaPedido['coste_linea'] = $costeLinea;        
   
        }else{
            unset($arrayPedido['productos'][$k]);
        }
    }

    return $resultado;
}

