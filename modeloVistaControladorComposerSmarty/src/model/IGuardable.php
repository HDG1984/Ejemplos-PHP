<?php

/**
 * La interfaz IGuardable define los métodos que deben implementarse
 * 
 */
interface IGuardable
{
    /**
     * Guarda la instancia actual de la clase en la base de datos.
     * @param $conexion La conexión PDO a la base de datos.
     */
    public function guardar(PDO $conexion);
    
    /**
     * Rescata una instancia de la clase de la base de datos según su ID.
     * @param $conexion La conexión PDO a la base de datos.
     * @param $id El ID de la instancia que se quiere rescatar.
     */
    public static function rescatar(PDO $conexion, $id);
    
    /**
     * Borra una instancia de la clase de la base de datos según su ID.
     * @param $conexion La conexión PDO a la base de datos.
     * @param $id El ID de la instancia que se quiere borrar.
     */
    public static function borrar(PDO $conexion, $id);
}
