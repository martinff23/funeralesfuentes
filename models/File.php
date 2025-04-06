<?php

namespace Model;

class File extends ActiveRecord{
    protected static $table = 'files';
    protected static $databaseColumns = ['id', 'route', 'image', 'real_name'];

    public $id;
    public $route;
    public $image;
    public $real_name;
    
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->route = $args['route'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->real_name = $args['real_name'] ?? '';
    }

    public function validate() {
        if("NONE" === strtoupper($this->route)) {
            self::$alerts['error'][] = 'La ruta es obligatoria';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'El nombre real es obligatorio';
        }
        if(!$this->real_name) {
            self::$alerts['error'][] = 'La imagen es obligatoria';
        }

        return self::$alerts;
    }
}

?>