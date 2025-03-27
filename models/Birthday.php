<?php

namespace Model;

class Birthday extends ActiveRecord {
    protected static $table = 'users';
    protected static $databaseColumns = ['id', 'birthday', 'name', 'f_name'];

    public $id;
    public $birthday;
    public $name;
    public $f_name;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->birthday = $args['birthday'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->f_name = $args['f_name'] ?? '';
    }
}