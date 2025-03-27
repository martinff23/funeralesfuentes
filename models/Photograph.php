<?php

namespace Model;

class Photograph extends ActiveRecord{
    protected static $table = 'users';
    protected static $databaseColumns = ['id', 'image'];

    public $id;
    public $image;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->image = $args['image'] ?? '';
    }

    public function validate() {
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }
    
        return self::$alerts;
    }
}