<?php






class Controladores {
  
    public static function controladorDefecto(Peticion $p, PDO $conexion, Smarty $s) {
        $productos = Producto::listar($conexion, 30, 2);
        $s->assign('productos', $productos);
        $s->display('listado.tpl.html');
    }

    public static function nuevoProducto(Peticion $p, PDO $conexion, Smarty $s) {
        $productos = Producto::guardar($conexion);
    }

    public static function editarProducto(Peticion $p, PDO $conexion, Smarty $s) {

    }

    public static function borrarProducto(Peticion $p, PDO $conexion, Smarty $s) {

    }
  
}

