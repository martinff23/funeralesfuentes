<?php

namespace Model;

class Service extends ActiveRecord{
    protected static $table = 'services';
    protected static $databaseColumns = ['id', 'category_id', 'service_name', 'service_description', 'service_cost', 'service_price', 'image', 'tags'];

    public $id;
    public $category_id;
    public $service_name;
    public $service_description;
    public $service_cost;
    public $service_price;
    public $image;
    public $tags;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->category_id = $args['category_id'] ?? 0;
        $this->service_name = $args['service_name'] ?? '';
        $this->service_description = $args['service_description'] ?? '';
        $this->service_cost = $args['service_cost'] ?? 0.0;
        $this->service_price = $args['service_price'] ?? 0.0;
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
    }

    public function validate() {
        if(!$this->service_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->category_id) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->service_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->service_cost) {
            self::$alerts['error'][] = 'El costo es obligatorio';
        }
        if(!$this->service_price) {
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