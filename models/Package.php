<?php

namespace Model;

class Package extends ActiveRecord{
    protected static $table = 'packages';
    protected static $databaseColumns = ['id', 'package_name', 'package_description', 'coffin', 'coffin_id', 'urn', 'urn_id', 'services', 'services_ids', 'complements', 'complements_ids', 'chapel', 'chapel_id', 'hearse', 'hearse_id', 'cemetery', 'cemetery_id', 'crematory', 'crematory_id', 'package_cost', 'package_price', 'image', 'tags'];

    public $id;
    public $package_name;
    public $package_description;
    public $coffin;
    public $coffin_id;
    public $urn;
    public $urn_id;
    public $services;
    public $services_ids;
    public $complements;
    public $complements_ids;
    public $chapel;
    public $chapel_id;
    public $hearse;
    public $hearse_id;
    public $cemetery;
    public $cemetery_id;
    public $crematory;
    public $crematory_id;
    public $package_cost;
    public $package_price;
    public $tags;

    public $image;
    public $currentImage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->package_name = $args['package_name'] ?? '';
        $this->package_description = $args['package_description'] ?? '';
        $this->coffin = $args['coffin'] ?? '';
        $this->coffin_id = $args['coffin_id'] ?? '';
        $this->urn = $args['urn'] ?? '';
        $this->urn_id = $args['urn_id'] ?? '';
        $this->services = $args['services'] ?? '';
        $this->services_ids = $args['services_ids'] ?? '';
        $this->complements = $args['complements'] ?? '';
        $this->complements_ids = $args['complements_ids'] ?? '';
        $this->chapel = $args['chapel'] ?? '';
        $this->chapel_id = $args['chapel_id'] ?? '';
        $this->hearse = $args['hearse'] ?? '';
        $this->hearse_id = $args['hearse_id'] ?? '';
        $this->cemetery = $args['cemetery'] ?? '';
        $this->cemetery_id = $args['cemetery_id'] ?? '';
        $this->crematory = $args['crematory'] ?? '';
        $this->crematory_id = $args['crematory_id'] ?? '';
        $this->package_cost = $args['package_cost'] ?? 0.0;
        $this->package_price = $args['package_price'] ?? 0.0;
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
    }

    public function validate() {
        if(!$this->package_name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->package_description) {
            self::$alerts['error'][] = 'La descripción es obligatoria';
        }
        if(!$this->coffin) {
            self::$alerts['error'][] = 'La selección de ataúd es obligatoria';
        }
        if(!$this->urn) {
            self::$alerts['error'][] = 'La selección de urna es obligatoria';
        }
        if(!$this->services) {
            self::$alerts['error'][] = 'La selección de servicios es obligatoria';
        }
        if(!$this->complements) {
            self::$alerts['error'][] = 'La selección de extras es obligatoria';
        }
        if(!$this->chapel) {
            self::$alerts['error'][] = 'La selección de capilla es obligatoria';
        }
        if(!$this->hearse) {
            self::$alerts['error'][] = 'La selección de carroza es obligatoria';
        }
        if(!$this->cemetery) {
            self::$alerts['error'][] = 'La selección de cementerio es obligatoria';
        }
        if(!$this->crematory) {
            self::$alerts['error'][] = 'La selección de crematorio es obligatoria';
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