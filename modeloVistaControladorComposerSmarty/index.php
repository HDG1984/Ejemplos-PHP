<?php

require_once __DIR__.'/vendor/autoload.php';
require_once 'conf.php';
require_once __DIR__.'/src/peticion.php';
  require_once __DIR__.'/src/model/Producto.php';
  require_once __DIR__.'/src/controllers/Controladores.php';

$conexion=connect();
if($conexion===false) die('No se puede conectar con la base de datos.');

$smarty=new Smarty();
$smarty->template_dir=TEMPLATE_DIR;
$smarty->compile_dir=TEMPLATE_C_DIR;
$smarty->cache_dir=CACHE_DIR;


$nuevaPeticion = new Peticion();

$ruta = $nuevaPeticion->getPath(ROOTPATH);

switch ($ruta){
    case '/DWES04/':
    case '/DWES04':
        if ($nuevaPeticion->getMethod() === 'GET' || $nuevaPeticion->getMethod() === 'POST') {
            Controladores::controladorDefecto($nuevaPeticion, $conexion, $smarty);
        }
        break;
        
    case '/DWES04/nuevoproducto/':
    case '/DWES04/nuevoproducto':
        if($metodo === 'POST'){
            Controladores::nuevoProducto($nuevaPeticion, $conexion, $smarty);
        }
        break;
        
    case '/DWES04/editarproducto/':
    case '/DWES04/editarproducto':
        if($nuevaPeticion->getMethod() === 'POST'){
            Controladores::editarProducto($nuevaPeticion, $pdo, $smarty);
        }
        break;
        
    case '/DWES04/borrarproducto/':
    case '/DWES04/borrarproducto':
        if($nuevaPeticion->getMethod() === 'POST'){
            Controladores::borrarProducto($nuevaPeticion, $pdo, $smarty);
        }
        break;
        
    default :
        echo 'Ruta ' . $ruta . '  no existente.';
}
