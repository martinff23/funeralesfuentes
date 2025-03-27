<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $table = '';
    protected static $databaseColumns = [];

    public $id;

    // Alertas y Mensajes
    protected static $alerts = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }    

    // Setear un tipo de Alerta
    public static function setAlert($type, $message) {
        self::$alerts[$type][] = $message;
    }

    // Obtener las alertas
    public static function getAlerts() {
        return self::$alerts;
    }

    // Validación que se hereda en modelos
    public function validate() {
        self::$alerts = [];
        return self::$alerts;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function querySQL($query) {
        // Consultar la base de datos
        // debug($query);
        $result = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($record = $result->fetch_assoc()) {
            $array[] = self::createObject($record);
        }

        // liberar la memoria
        $result->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function createObject($record) {
        $object = new static;

        foreach($record as $key => $value ) {
            if(property_exists( $object, $key  )) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    // Identificar y unir los atributos de la BD
    public function attributes() {
        $attributes = [];
        foreach(static::$databaseColumns as $column) {
            if($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizeAttributes() {
        $attributes = $this->attributes();
        $sanitized = [];
        foreach($attributes as $key => $value ) {
            $sanitized[$key] = self::$db->escape_string($value);
        }
        return $sanitized;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronize($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function saveElement() {
        $result = '';
        if(!is_null($this->id)) {
            // actualizar
            $result = $this->updateElement();
        } else {
            // Creando un nuevo registro
            $result = $this->createElement();
        }
        return $result;
    }

    // Obtener todos los Registros
    public static function all() {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC";
        $result = self::querySQL($query);
        return $result;
    }

    // Obtener todos los Registros vinculados a una palabra
    public static function allWhere($columnName,$columnValue) {
        $query = "SELECT * FROM " . static::$table . " WHERE ".$columnName." LIKE '%" .$columnValue. "%' ORDER BY ".$columnName." ASC";
        $result = self::querySQL($query);
        return $result;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table . " WHERE id = " . $id ;
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limit) {
        $query = "SELECT * FROM " . static::$table . " LIMIT ".$limit." ORDER BY id DESC" ;
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // Records pagination
    public static function paginate($recordsPerPage, $offset){
        $query = "SELECT * FROM " . static::$table . " ORDER BY id ASC LIMIT ".$recordsPerPage." OFFSET ".$offset."" ;
        $result = self::querySQL($query);
        return $result;
    }

    // Busqueda Where con Columna 
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE ".$column." = '".$value."'";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // Count total records
    public static function countRecords(){
        $query = "SELECT COUNT(*) FROM " . static::$table;
        $result = self::$db->query($query);
        $total = $result->fetch_array();
        return array_shift($total);
    }

    // Return the records by order
    public static function order($column, $order){
        $query = "SELECT * FROM " . static::$table . " ORDER BY ".$column." ".$order;
        $result = self::querySQL($query);
        return $result;
    }

    // crea un nuevo registro
    public function createElement() {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        // debug($query); // Descomentar si no te funciona algo

        // Resultado de la consulta
        $result = self::$db->query($query);
        return [
           'result' =>  $result,
           'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function updateElement() {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Iterar para ir agregando cada campo de la BD
        $values = [];
        foreach($attributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $values );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $result = self::$db->query($query);
        return $result;
    }

    // Eliminar un Registro por su ID
    public function deleteElement() {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . static::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }
}