<?php

namespace Model;

class Branch extends ActiveRecord{
    protected static $table = 'branches';
    protected static $databaseColumns = ['id', 'category_id', 'branch_name', 'branch_description', 'branch_ISO', 'image', 'telephone', 'branch_networks', 'latitude', 'longitude', 'address', 'open_date'];

    public $id;
    public $category_id;
    public $branch_name;
    public $branch_description;
    public $branch_ISO;
    public $image;
    public $telephone;
    public $branch_networks;
    public $latitude;
    public $longitude;
    public $address;
    public $open_date;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->category_id = $args['category_id'] ?? 0;
        $this->branch_name = $args['branch_name'] ?? '';
        $this->branch_description = $args['branch_description'] ?? '';
        $this->branch_ISO = $args['branch_ISO'] ?? 0.0;
        $this->image = $args['image'] ?? '';
        $this->telephone = $args['telephone'] ?? '';
        $this->branch_networks = $args['branch_networks'] ?? '';
        $this->latitude = $args['latitude'] ?? '';
        $this->longitude = $args['longitude'] ?? '';
        $this->address = $args['address'] ?? '';
        $this->open_date = $args['open_date'] ?? '';
    }

    public function validate() {
        if(!$this->branch_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->category_id) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->branch_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->branch_ISO) {
            self::$alerts['error'][] = 'El ISO es obligatorio';
        }
        if(!$this->telephone) {
            self::$alerts['error'][] = 'La teléfono es obligatorio';
        }
        if(!$this->open_date) {
            self::$alerts['error'][] = 'La fecha de apertura es obligatoria';
        }
    
        return self::$alerts;
    }
}

?>