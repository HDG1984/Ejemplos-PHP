<?php

/**
 * Interfaz IListable
 * 
 * Esta interfaz define los métodos necesarios para obtener una lista de objetos
 */
interface IListable
{
    
    /**
     * Método estático para listar objetos.
     *
     * @param $conexion La conexión PDO a la fuente de datos.
     * @param $limite El número máximo de objetos que se deben devolver.
     * @param $offset El número de objetos que se deben omitir desde el principio.
     */
    public static function listar(PDO $conexion, int $limite, int $offset);
    
     /**
     * Método estático para contar el número total de objetos.
     *
     * @param $conexion La conexión PDO a la fuente de datos.
     */
    public static function contar(PDO $conexion);
}

