<?php

namespace Model;

class Chapel extends ActiveRecord{
    protected static $table = 'chapels';
    protected static $databaseColumns = ['id', 'category_id', 'chapel_name', 'chapel_description', 'chapel_cost', 'chapel_price', 'chapel_inventory', 'image', 'tags', 'chapel_networks'];

    public $id;
    public $category_id;
    public $chapel_name;
    public $chapel_description;
    public $chapel_cost;
    public $chapel_price;
    public $chapel_inventory;
    public $image;
    public $tags;
    public $chapel_networks;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->category_id = $args['category_id'] ?? 0;
        $this->chapel_name = $args['chapel_name'] ?? '';
        $this->chapel_description = $args['chapel_description'] ?? '';
        $this->chapel_cost = $args['chapel_cost'] ?? 0.0;
        $this->chapel_price = $args['chapel_price'] ?? 0.0;
        $this->chapel_inventory = $args['chapel_inventory'] ?? 0;
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->chapel_networks = $args['chapel_networks'] ?? '';
    }

    public function validate() {
        if(!$this->chapel_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->category_id) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->chapel_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->chapel_cost) {
            self::$alerts['error'][] = 'El costo es obligatorio';
        }
        if(!$this->chapel_price) {
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