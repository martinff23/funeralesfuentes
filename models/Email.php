<?php

namespace Model;

class Email extends ActiveRecord {
    protected static $table = 'users';
    protected static $databaseColumns = ['id', 'email'];

    public $id;
    public $email;
    
    public $email2;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->email2 = $args['email2'] ?? '';
    }

    // Validar el Login de Usuarios
    public function validateEmail() {
        if (!$this->email) {
            self::$alerts['error'][] = 'El correo electrónico es obligatorio';
            return;
        }
    
        // Validar formato de email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'El formato del correo electrónico no es válido';
        }
    
        // Validar que email y email2 sean iguales (si se pasa email2)
        if ($this->email2 && $this->email !== $this->email2) {
            self::$alerts['error'][] = 'Los correos electrónicos no coinciden';
        }
    
        return self::$alerts;
    }
}