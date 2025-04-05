<?php

namespace Model;

class Hearse extends ActiveRecord{
    protected static $table = 'hearses';
    protected static $databaseColumns = ['id', 'category_id', 'hearse_name', 'hearse_description', 'hearse_cost', 'hearse_price', 'hearse_inventory', 'hearse_brand', 'hearse_model', 'image', 'tags', 'hearse_networks', 'status', 'purchase_date'];

    public $id;
    public $category_id;
    public $hearse_name;
    public $hearse_description;
    public $hearse_cost;
    public $hearse_price;
    public $hearse_inventory;
    public $hearse_brand;
    public $hearse_model;
    public $image;
    public $tags;
    public $hearse_networks;
    public $status;
    public $purchase_date;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->category_id = $args['category_id'] ?? 0;
        $this->hearse_name = $args['hearse_name'] ?? '';
        $this->hearse_description = $args['hearse_description'] ?? '';
        $this->hearse_cost = $args['hearse_cost'] ?? 0.0;
        $this->hearse_price = $args['hearse_price'] ?? 0.0;
        $this->hearse_inventory = $args['hearse_inventory'] ?? 0;
        $this->hearse_brand = $args['hearse_brand'] ?? '';
        $this->hearse_model = $args['hearse_model'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->hearse_networks = $args['hearse_networks'] ?? '';
        $this->purchase_date = $args['purchase_date'] ?? '';
        $this->status = $args['status'] ?? '';
    }

    public function validate() {
        if(!$this->hearse_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->category_id) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->hearse_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->hearse_cost) {
            self::$alerts['error'][] = 'El costo es obligatorio';
        }
        if(!$this->hearse_price) {
            self::$alerts['error'][] = 'El precio es obligatorio';
        }
        if(!$this->hearse_brand) {
            self::$alerts['error'][] = 'La marca es obligatoria';
        }
        if(!$this->hearse_model) {
            self::$alerts['error'][] = 'El modelo es obligatorio';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }
        if(!$this->tags) {
            self::$alerts['error'][] = 'Al menos una característica es obligatoria';
        }
        if(!$this->purchase_date) {
            self::$alerts['error'][] = 'La fecha de compra es obligatoria';
        }
        if("NONE" === strtoupper($this->status)) {
            self::$alerts['error'][] = 'El estado es obligatorio';
        }
    
        return self::$alerts;
    }
}

?>