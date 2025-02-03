<?php

namespace Model;

class User extends ActiveRecord {
    protected static $table = 'usuarios';
    protected static $databaseColumns = ['id', 'name', 'f_name', 'email', 'password', 'confirmed', 'token', 'admin'];

    public $id;
    public $name;
    public $f_name;
    public $email;
    public $password;
    public $password2;
    public $confirmed;
    public $token;
    public $admin;

    public $currentPassword;
    public $newPassword;

    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->f_name = $args['f_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? '';
    }

    // Validar el Login de Usuarios
    public function validateLogin() {
        if(!$this->email) {
            self::$alerts['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'El Password no puede ir vacio';
        }
        return self::$alerts;

    }

    // Validación para cuentas nuevas
    public function validateAccount() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->f_name) {
            self::$alerts['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->email) {
            self::$alerts['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alerts['error'][] = 'Los password son diferentes';
        }
        return self::$alerts;
    }

    // Valida un email
    public function validateEmail() {
        if(!$this->email) {
            self::$alerts['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Email no válido';
        }
        return self::$alerts;
    }

    // Valida el Password 
    public function validatePassword() {
        if(!$this->password) {
            self::$alerts['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alerts;
    }

    public function newPassword() : array {
        if(!$this->currentPassword) {
            self::$alerts['error'][] = 'El Password Actual no puede ir vacio';
        }
        if(!$this->newPassword) {
            self::$alerts['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if(strlen($this->newPassword) < 6) {
            self::$alerts['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alerts;
    }

    // Comprobar el password
    public function verifyPassword() : bool {
        return password_verify($this->currentPassword, $this->password );
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function createToken() : void {
        $this->token = uniqid();
    }
}