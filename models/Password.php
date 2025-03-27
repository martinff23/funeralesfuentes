<?php

namespace Model;

class Password extends ActiveRecord {
    protected static $table = 'users';
    protected static $databaseColumns = ['id', 'password'];

    public $id;
    public $password;
    
    public $password2;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
    }

    // Validar el Login de Usuarios
    public function validatePassword() {
        if (!$this->password) {
            self::$alerts['error'][] = 'La contraseña es obligatoria';
            return;
        }
    
        // Longitud mínima
        if (strlen($this->password) < 8) {
            self::$alerts['error'][] = 'La contraseña debe tener al menos 8 caracteres';
        }
    
        // Al menos una letra mayúscula
        if (!preg_match('/[A-Z]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos una letra mayúscula';
        }
    
        // Al menos una letra minúscula
        if (!preg_match('/[a-z]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos una letra minúscula';
        }
    
        // Al menos un número
        if (!preg_match('/[0-9]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos un número';
        }
    
        // Al menos un carácter especial
        if (!preg_match('/[\W_]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos un carácter especial';
        }
    
        // Comparación con password2
        if ($this->password2 && $this->password !== $this->password2) {
            self::$alerts['error'][] = 'Las contraseñas no coinciden';
        }
    
        return self::$alerts;
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
}