<?php

namespace Model;

class User extends ActiveRecord {
    protected static $table = 'users';
    protected static $databaseColumns = ['id', 'name', 'f_name', 'email', 'telephone', 'password', 'image', 'confirmed', 'token', 'isAdmin', 'isEmployee', 'acceptsMarketing', 'acceptsPromos', 'status', 'registerOrigin'];

    public $id;
    public $name;
    public $f_name;
    public $email;
    public $telephone;
    public $password;
    public $image;
    public $password2;
    public $confirmed;
    public $token;
    public $isAdmin;
    public $isEmployee;
    public $acceptsMarketing;
    public $acceptsPromos;
    public $status;
    public $registerOrigin;

    public $currentPassword;
    public $currentImage;
    public $newPassword;

    
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->f_name = $args['f_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telephone = $args['telephone'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->isAdmin = $args['isAdmin'] ?? 0;
        $this->isEmployee = $args['isEmployee'] ?? 0;
        $this->acceptsMarketing = $args['acceptsMarketing'] ?? 0;
        $this->acceptsPromos = $args['acceptsPromos'] ?? 0;
        $this->status = $args['status'] ?? '';
        $this->registerOrigin = $args['registerOrigin'] ?? '0';
    }

    // Validar el Login de Usuarios
    public function validateLogin() {
        if(!$this->email) {
            self::$alerts['error'][] = 'El correo electrónico del usuario es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Correo electrónico no válido';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'La contraseña no puede ir vacia';
        }
        return self::$alerts;

    }

    // Validate password
    public function validarPasswordRecovery(){
        if(!$this->password) {
            self::$alerts['error'][] = 'La contraseña no puede ir vacia';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alerts['error'][] = 'Las contraseñas son diferentes';
        }
        return self::$alerts;
    }

    // Validación para cuentas nuevas
    public function validateAccount() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->f_name) {
            self::$alerts['error'][] = 'El apellido es obligatorio';
        }
        if(!$this->email) {
            self::$alerts['error'][] = 'El correo electrónico es obligatorio';
        }
        if(!$this->telephone) {
            self::$alerts['error'][] = 'El teléfono es obligatorio';
        }
        if (!$this->password) {
            self::$alerts['error'][] = 'La contraseña es obligatoria';
        }
    
        // Minimum length
        if (strlen($this->password) < $_ENV['PASSWORD_LENGTH']) {
            self::$alerts['error'][] = 'La contraseña debe tener al menos 8 caracteres';
        }
    
        // At least one capital letter
        if (!preg_match('/[A-Z]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos una letra mayúscula';
        }
    
        // At least one normal letter
        if (!preg_match('/[a-z]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos una letra minúscula';
        }
    
        // At least one number
        if (!preg_match('/[0-9]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos un número';
        }
    
        // Password confirmation
        if ($this->password2 && $this->password !== $this->password2) {
            self::$alerts['error'][] = 'Las contraseñas no coinciden';
        }
        return self::$alerts;
    }

    // Valida un email
    public function validateEmail() {
        if(!$this->email) {
            self::$alerts['error'][] = 'El correo electrónico es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Correo electrónico no válido';
        }
        return self::$alerts;
    }

    // Valida el Password 
    public function validatePasswordRecovery() {
        // Minimum length
        if (strlen($this->password) < $_ENV['PASSWORD_LENGTH']) {
            self::$alerts['error'][] = 'La contraseña debe tener al menos 8 caracteres';
        }
    
        // At least one capital letter
        if (!preg_match('/[A-Z]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos una letra mayúscula';
        }
    
        // At least one normal letter
        if (!preg_match('/[a-z]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos una letra minúscula';
        }
    
        // At least one number
        if (!preg_match('/[0-9]/', $this->password)) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos un número';
        }
    
        // Password confirmation
        if ($this->password2 && $this->password !== $this->password2) {
            self::$alerts['error'][] = 'Las contraseñas no coinciden';
        }
        return self::$alerts;
    }

    public function newPassword() : array {
        if(!$this->currentPassword) {
            self::$alerts['error'][] = 'La contraseña actual no puede ir vacio';
        }
        if(!$this->newPassword) {
            self::$alerts['error'][] = 'La contraseña nueva no puede ir vacio';
        }
        if(strlen($this->newPassword) < 6) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos 6 caracteres';
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