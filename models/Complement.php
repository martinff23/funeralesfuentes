<?php

namespace Model;

class Complement extends ActiveRecord{
    protected static $table = 'complements';
    protected static $databaseColumns = ['id', 'category', 'complement_name', 'complement_description', 'complement_cost', 'complement_price', 'image', 'tags', 'complement_networks'];

    public $id;
    public $category;
    public $complement_name;
    public $complement_description;
    public $complement_cost;
    public $complement_price;
    public $image;
    public $tags;
    public $complement_networks;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->category = $args['category'] ?? 0;
        $this->complement_name = $args['complement_name'] ?? '';
        $this->complement_description = $args['complement_description'] ?? '';
        $this->complement_cost = $args['complement_cost'] ?? 0.0;
        $this->complement_price = $args['complement_price'] ?? 0.0;
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->complement_networks = $args['complement_networks'] ?? '';
    }

    public function validate() {
        if(!$this->complement_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->category) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->complement_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->complement_cost) {
            self::$alerts['error'][] = 'El costo es obligatorio';
        }
        if(!$this->complement_price) {
            self::$alerts['error'][] = 'El precio es obligatorio';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }
        if(!$this->tags) {
            self::$alerts['error'][] = 'Al menos una característica es obligatoria';
        }
    
        return self::$alerts;
    }
}

?>