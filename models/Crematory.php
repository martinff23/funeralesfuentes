<?php

namespace Model;

class Crematory extends ActiveRecord{
    protected static $table = 'crematories';
    protected static $databaseColumns = ['id', 'category_id', 'crematory_name', 'crematory_description', 'crematory_cost', 'crematory_price', 'crematory_inventory', 'image', 'tags', 'crematory_networks', 'latitude', 'longitude', 'address', 'open_date', 'status'];

    public $id;
    public $category_id;
    public $crematory_name;
    public $crematory_description;
    public $crematory_cost;
    public $crematory_price;
    public $crematory_inventory;
    public $image;
    public $tags;
    public $crematory_networks;
    public $latitude;
    public $longitude;
    public $address;
    public $open_date;
    public $status;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->category_id = $args['category_id'] ?? 0;
        $this->crematory_name = $args['crematory_name'] ?? '';
        $this->crematory_description = $args['crematory_description'] ?? '';
        $this->crematory_cost = $args['crematory_cost'] ?? 0.0;
        $this->crematory_price = $args['crematory_price'] ?? 0.0;
        $this->crematory_inventory = $args['crematory_inventory'] ?? 0;
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->crematory_networks = $args['crematory_networks'] ?? '';
        $this->latitude = $args['latitude'] ?? '';
        $this->longitude = $args['longitude'] ?? '';
        $this->address = $args['address'] ?? '';
        $this->open_date = $args['open_date'] ?? '';
        $this->status = $args['status'] ?? '';
    }

    public function validate() {
        if(!$this->crematory_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->category_id) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->crematory_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->crematory_cost) {
            self::$alerts['error'][] = 'El costo es obligatorio';
        }
        if(!$this->crematory_price) {
            self::$alerts['error'][] = 'El precio es obligatorio';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }
        if(!$this->tags) {
            self::$alerts['error'][] = 'Al menos una característica es obligatoria';
        }
        if(!$this->open_date) {
            self::$alerts['error'][] = 'La fecha de apertura es obligatoria';
        }
        if("NONE" === strtoupper($this->status)) {
            self::$alerts['error'][] = 'El estado es obligatorio';
        }
    
        return self::$alerts;
    }
}

?>