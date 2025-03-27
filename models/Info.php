<?php

namespace Model;

class Info extends ActiveRecord {
    protected static $table = 'users';
    protected static $databaseColumns = ['id', 'name', 'f_name', 'telephone', 'birthday'];

    public $id;
    public $name;
    public $f_name;
    public $telephone;
    public $birthday;

    
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->f_name = $args['f_name'] ?? '';
        $this->telephone = $args['telephone'] ?? '';
        $this->birthday = $args['birthday'] ?? '';
    }

    // Validar el Login de Usuarios
    public function validateInfo() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El nombre del usuario es obligatorio';
        }
        if(!$this->f_name) {
            self::$alerts['error'][] = 'El(los) apellido(s) del usuario es obligatorio';
        }
        if(!$this->telephone) {
            self::$alerts['error'][] = 'El teléfono del usuario es obligatorio';
        }
        if(!$this->birthday) {
            self::$alerts['error'][] = 'El cumpleaños del usuario es obligatorio';
        }
    }
}