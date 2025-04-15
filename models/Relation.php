<?php

namespace Model;

class Relation extends ActiveRecord {
    protected static $table = 'emcontact_relations';
    protected static $databaseColumns = ['id', 'name', 'visual_name', 'status'];

    public $id;
    public $name;
    public $visual_name;
    public $status;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->visual_name = $args['visual_name'] ?? '';
        $this->status = $args['status'] ?? 'ACTIVE';
    }
}