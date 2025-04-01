<?php

namespace Model;

class Branch extends ActiveRecord{
    protected static $table = 'branches';
    protected static $databaseColumns = ['id', 'category_id', 'branch_name', 'branch_description', 'branch_ISO', 'image', 'telephone', 'branch_networks', 'latitude', 'longitude', 'address', 'open_date', 'status', 'tags'];

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
    public $status;
    public $tags;
    
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
        $this->status = $args['status'] ?? '';
        $this->tags = $args['tags'] ?? '';
    }

    public function validate() {
        if(!$this->branch_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->branch_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->branch_ISO) {
            self::$alerts['error'][] = 'El ISO es obligatorio';
        }
        if(!$this->address) {
            self::$alerts['error'][] = 'La dirección es obligatoria';
        }
        if(!$this->telephone) {
            self::$alerts['error'][] = 'El teléfono es obligatorio';
        }
        if(!$this->latitude) {
            self::$alerts['error'][] = 'La latitud es obligatoria';
        }
        if(!$this->longitude) {
            self::$alerts['error'][] = 'La longitud es obligatoria';
        }
        if(!$this->open_date) {
            self::$alerts['error'][] = 'La fecha de apertura es obligatoria';
        }
        if("NONE" === $this->status) {
            self::$alerts['error'][] = 'El estado es obligatorio';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }
        if(!$this->category_id) {
            self::$alerts['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->tags) {
            self::$alerts['error'][] = 'Al menos una característica es obligatoria';
        }
    
        return self::$alerts;
    }
}

?>