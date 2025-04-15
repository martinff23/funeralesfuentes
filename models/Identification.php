<?php

namespace Model;

class Identification extends ActiveRecord {
    protected static $table = 'identifications';
    protected static $databaseColumns = ['id', 'name', 'visual_name', 'country', 'status'];

    public $id;
    public $name;
    public $visual_name;
    public $country;
    public $status;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->visual_name = $args['visual_name'] ?? '';
        $this->country = $args['country'] ?? '';
        $this->status = $args['status'] ?? 'ACTIVE';
    }
    
    public function validate() {
        if('none'===strtolower($this->name)){
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if('none'===strtolower($this->visual_name)){
            self::$alerts['error'][] = 'El nombre visual es obligatorio';
        }
        if(!$this->country){
            self::$alerts['error'][] = 'El país es obligatorio';
        }
        if('none'===strtolower($this->status)){
            self::$alerts['error'][] = 'El estado es obligatorio';
        }

        return self::$alerts;
    }
}