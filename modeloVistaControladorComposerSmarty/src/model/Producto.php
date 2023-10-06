<?php
require_once 'IGuardable.php';
require_once 'IListable.php';

class Producto implements IGuardable, IListable{
    
    private $id = null;
    private $cod;
    private $desc;
    private $precio;
    private $stock;
    /*
    public function __construct($cod, $desc, $precio, $stock){
        $this->cod = $cod;
        $this->desc = $desc;
        $this->precio = $precio;
        $this->stock = $stock;
    }
    */
    
    public function getId(){
        return $this->id;
    }
    
    public function getPrecio(){
        return $this->precio;
    }
    
    public function getDesc(){
        return $this->desc;
    }
    
    public function getCod(){
        return $this->cod;
    }
    
    public function getStock(){
        return $this->stock;
    }
    
    
    /**
    * Asigna un valor al precio del producto.
    *
    * @param $precio El precio del producto.
    * @return true si se asigna el valor, false si no.
    */
    public function setPrecio($precio){
        
        if (is_numeric($precio) && $precio > 0) {
            $this->precio = $precio;
            return true;
        } else {
            return false;
        }
        
    }
    
    /**
    * Asigna un valor al stock del producto.
    *
    * @param $stock El stock del producto.
    * @return true si se asigna el valor, false si no.
    */
    public function setStock($stock){
        
        if (is_numeric($stock) && $stock > 0) {
            $this->stock = $stock;
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
    * Asigna un valor al código del producto.
    *
    * @param $cod El código del producto.
    * @return true si se asigna el valor, false si no.
    */
    public function setCod($cod){
        if (preg_match('/^[A-Z][0-9][1-9]$/', $cod)) {
            $this->cod = $cod;
            return true;
        } else {
            return false;
        }
    }
    
    /**
    * Establece la descripción del producto y eliminamos etiquetas HTML con (strip_tags)y espacios en blanco al inicio y al final con (trim).
    *
    * @param $desc La descripción del producto.
    *
    * @return true si la descripción se ha establecido correctamente, false en caso contrario.
    */
    public function setDesc($desc){
        $desc = trim(strip_tags($desc)); 
        if (strlen($desc) < 2) {
            return false; 
        }
        $this->desc = $desc;
        return true;
    }
    
   
    
    
    /**
     * Guarda (INSERT) o modifica (UPDATE) el contenido en la base de datos asociado a este producto, en caso de que sea la primera
     * vez que se guarde, cambiará el valor del atributo id de la clase apropiadamente, si la consulta falla o se genera una excepción, 
     * retorna false.
     * @param $conexion Una instancia de la clase PDO con la conexión a la base de datos.
     * @return Retorna el número de filas modificadas o creadas en la base de datos, en caso de que todo haya ido bien.
     */
    public function guardar(PDO $conexion){
        try {
            $stmt = $conexion->prepare("SELECT id FROM productos WHERE cod = ?");
            $stmt->execute([$this->cod]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->id = $row['id'];
                $stmt = $conexion->prepare("UPDATE productos SET `desc` = ?, precio = ?, stock = ? WHERE id = ?");
                $stmt->execute([$this->desc, $this->precio, $this->stock, $this->id]);
            } else {
                $stmt = $conexion->prepare("INSERT INTO productos (cod, `desc`, precio, stock) VALUES (?, ?, ?, ?)");
                $stmt->execute([$this->cod, $this->desc, $this->precio, $this->stock]);
                $this->id = $conexion->lastInsertId(); 
            }
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            return false;
        }
    }

    
    
    /**
    * Rescata el registro con el id indicado y retorna una instancia de la clase Producto con los datos rescatados.
    *
    * @param $conexion Una instancia de la clase PDO con la conexión a la base de datos.
    * @param $id El id del Producto que se desea rescatar.
    * @return Una instancia de la clase Producto con los datos rescatados o null si no se encuentra ningún Producto con el id indicado.
    */ 
    public static function rescatar(PDO $conexion, $id){
        try {
            $stmt = $conexion->prepare("SELECT id, cod, `desc`, precio, stock FROM productos WHERE id = ?");
            $stmt->execute([$id]);

            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                $producto = new Producto();
                foreach ($fila as $key => $value) {
                    $producto->$key = $value;
                }
                return $producto;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    
    
    /**
    * Elimina de la base de datos el registro con el id indicado de la tabla correspondiente.
    * 
    * @param $conexion La instancia de la clase PDO que representa la conexión a la base de datos.
    * @param $id El identificador del producto a borrar.
    * @return Retorna el número de filas eliminadas de la base de datos. En caso de falla o excepción, retorna false.
    */
    public static function borrar(PDO $conexion, $id) {
        try {
            $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->rowCount();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
    * Lista los productos almacenados en la base de datos.
    *
    * @param $conexion La instancia de la clase PDO que representa la conexión a la base de datos.
    * @param $limit Límite de registros a obtener.
    * @param $offset Offset para empezar a obtenerlos.
    *
    * @return Array de instancias de la clase Producto con los datos de los productos almacenados en la base de datos, false en caso de que 
    * la consulta haya fallado o se haya generado una excepción.
    */
    public static function listar(PDO $conexion, $limit, $offset){
        try {
            $stmt = $conexion->prepare("SELECT id FROM productos LIMIT $limit OFFSET $offset");
            $stmt->execute();
            $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $productos = array();
            foreach ($ids as $id) {
                $producto = self::rescatar($conexion, $id);
                if ($producto) {
                    $productos[] = $producto;
                }
            }

            return $productos;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
    * Obtiene el número de productos almacenados en la base de datos.
    *
    * @param $conexion La instancia de la clase PDO que representa la conexión a la base de datos.
    *
    * @return Número de productos almacenados en la base de datos, false en caso de que la consulta haya fallado o se haya generado una excepción.
    */
    public static function contar(PDO $conexion){
        try {
            $stmt = $conexion->prepare("SELECT count(id) from productos");
            $stmt->execute();
            $count = $stmt->fetchColumn();

            return $count;
        } catch (PDOException $e) {
            return false;
        }
    }
}

