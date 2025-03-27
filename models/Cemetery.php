<?php

namespace Model;

class Cemetery extends ActiveRecord{
    protected static $table = 'cemeteries';
    protected static $databaseColumns = ['id', 'category_id', 'cemetery_name', 'cemetery_description', 'cemetery_cost', 'cemetery_price', 'cemetery_inventory', 'image', 'tags', 'cemetery_networks'];

    public $id;
    public $category_id;
    public $cemetery_name;
    public $cemetery_description;
    public $cemetery_cost;
    public $cemetery_price;
    public $cemetery_inventory;
    public $image;
    public $tags;
    public $cemetery_networks;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->category_id = $args['category_id'] ?? 0;
        $this->cemetery_name = $args['cemetery_name'] ?? '';
        $this->cemetery_description = $args['cemetery_description'] ?? '';
        $this->cemetery_cost = $args['cemetery_cost'] ?? 0.0;
        $this->cemetery_price = $args['cemetery_price'] ?? 0.0;
        $this->cemetery_inventory = $args['cemetery_inventory'] ?? 0;
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->cemetery_networks = $args['cemetery_networks'] ?? '';
    }

    public function validate() {
        if(!$this->cemetery_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->category_id) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->cemetery_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->cemetery_cost) {
            self::$alerts['error'][] = 'El costo es obligatorio';
        }
        if(!$this->cemetery_price) {
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