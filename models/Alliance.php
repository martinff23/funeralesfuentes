<?php

namespace Model;

class Alliance extends ActiveRecord{
    protected static $table = 'alliances';
    protected static $databaseColumns = ['id', 'business_name', 'image', 'status'];

    public $id;
    public $business_name;
    public $image;
    public $status;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->business_name = $args['business_name'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->status = $args['status'] ?? '';
    }

    public function validate() {
        if(!$this->business_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }
        if("NONE" === strtoupper($this->status)) {
            self::$alerts['error'][] = 'El estado es obligatorio';
        }
    }
}

?>