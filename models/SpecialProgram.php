<?php

namespace Model;

class SpecialProgram extends ActiveRecord {
    protected static $table = 'special_programs';
    protected static $databaseColumns = ['id', 'name', 'visual_name', 'source', 'status'];

    public $id;
    public $name;
    public $visual_name;
    public $source;
    public $status;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->visual_name = $args['visual_name'] ?? '';
        $this->source = $args['source'] ?? '';
        $this->status = $args['status'] ?? 'ACTIVE';
    }
    
    public function validate() {
        if('none'===strtolower($this->name)){
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if('none'===strtolower($this->visual_name)){
            self::$alerts['error'][] = 'El nombre visual es obligatorio';
        }
        if(!$this->source){
            self::$alerts['error'][] = 'La fuente del programa es obligatoria';
        }
        if('none'===strtolower($this->status)){
            self::$alerts['error'][] = 'El estado es obligatorio';
        }

        return self::$alerts;
    }
}