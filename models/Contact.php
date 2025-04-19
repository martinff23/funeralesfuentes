<?php

namespace Model;

class Contact extends ActiveRecord{
    protected static $table = 'contact';
    protected static $databaseColumns = ['id', 'name', 'telephone', 'email', 'status', 'assignee', 'entered_date', 'closed_date'];

    public $id;
    public $name;
    public $telephone;
    public $email;
    public $status;
    public $assignee;
    public $entered_date;
    public $closed_date;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->telephone = $args['telephone'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->status = $args['status'] ?? 'ACTIVE';
        $this->assignee = $args['assignee'] ?? 0;
        $this->entered_date = $args['entered_date'] ?? '';
        $this->closed_date = $args['closed_date'] ?? '';
    }

    public function validate() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->telephone) {
            self::$alerts['error'][] = 'El teléfono es obligatorio';
        }
        if(!$this->email) {
            self::$alerts['error'][] = 'El correo electrónico es obligatorio';
        }
    }
}

?>