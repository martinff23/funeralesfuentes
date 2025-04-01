<?php

namespace Model;

class Product extends ActiveRecord{
    protected static $table = 'products';
    protected static $databaseColumns = ['id', 'category_id', 'product_name', 'product_description', 'product_cost', 'product_price', 'product_inventory', 'image', 'tags', 'product_networks', 'SKU'];

    public $id;
    public $category_id;
    public $product_name;
    public $product_description;
    public $product_cost;
    public $product_price;
    public $product_inventory;
    public $image;
    public $tags;
    public $product_networks;
    public $SKU;
    
    public $currentImage;
    public $category;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->category_id = $args['category_id'] ?? 0;
        $this->product_name = $args['product_name'] ?? '';
        $this->product_description = $args['product_description'] ?? '';
        $this->product_cost = $args['product_cost'] ?? 0.0;
        $this->product_price = $args['product_price'] ?? 0.0;
        $this->product_inventory = $args['product_inventory'] ?? 0;
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->product_networks = $args['product_networks'] ?? '';
        $this->SKU = $args['SKU'] ?? '';
    }

    public function validate() {
        if(!$this->product_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->category_id) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->product_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->product_cost) {
            self::$alerts['error'][] = 'El costo es obligatorio';
        }
        if(!$this->product_price) {
            self::$alerts['error'][] = 'El precio es obligatorio';
        }
        if(!$this->product_inventory) {
            self::$alerts['error'][] = 'El inventario es obligatorio';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }
        if(!$this->tags) {
            self::$alerts['error'][] = 'Al menos una característica es obligatoria';
        }
        if(!$this->SKU) {
            self::$alerts['error'][] = 'El SKU es obligatorio';
        }
    
        return self::$alerts;
    }
}

?>