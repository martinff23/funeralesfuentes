<?php

namespace Model;

class Subscription extends ActiveRecord {
    protected static $table = 'users';
    protected static $databaseColumns = ['id', 'acceptsMarketing', 'acceptsPromos'];

    public $id;
    public $acceptsMarketing;
    public $acceptsPromos;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->acceptsMarketing = $args['acceptsMarketing'] ?? '';
        $this->acceptsPromos = $args['acceptsPromos'] ?? '';
    }
    
    public function validate() {
        // if(!$this->acceptsMarketing) {
        //     self::$alerts['error'][] = 'La selección de publicidad es obligatoria';
        // } else 
        if('none'===strtolower($this->acceptsMarketing)){
            self::$alerts['error'][] = 'La selección de publicidad es obligatoria';
        }
        // if(!$this->acceptsPromos) {
        //     self::$alerts['error'][] = 'La selección de promociones es obligatoria';
        // } else 
        if('none'===strtolower($this->acceptsPromos)){
            self::$alerts['error'][] = 'La selección de promociones es obligatoria';
        }

        return self::$alerts;
    }
}