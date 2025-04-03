<?php

namespace Model;

class Contact extends ActiveRecord{
    protected static $table = 'contact';
    protected static $databaseColumns = ['id', 'name', 'telephone', 'email', 'status'];

    public $id;
    public $name;
    public $telephone;
    public $email;
    public $status;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->telephone = $args['telephone'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->status = $args['status'] ?? 'CONTACT_URGENT';
    }

    public function validate() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->telephone) {
            self::$alerts['error'][] = 'El teléfono es obligatori0';
        }
        if(!$this->email) {
            self::$alerts['error'][] = 'El correo electrónico es obligatori0';
        }
    }
}

?>