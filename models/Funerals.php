<?php

namespace Model;

class Funerals extends ActiveRecord{
    protected static $table = 'funerals';
    protected static $databaseColumns = ['id', 'package_id', 'coffins', 'urns', 'services', 'complements', 'chapels', 'hearses', 'cemeteries', 'crematories', 'funeral_price', 'funeral_cost', 'funeral_date', 'funeral_receiver_name', 'funeral_receiver_birthday', 'funeral_receiver_cause_of_death', 'funeral_receiver_death_date', 'funeral_receiver_photograph', 'funeral_contractor_id', 'funeral_notes', 'funeral_status'];

    public $id;
    public $package_id;
    public $coffins;
    public $urns;
    public $services;
    public $complements;
    public $chapels;
    public $hearses;
    public $cemeteries;
    public $crematories;
    public $funeral_price;
    public $funeral_cost;
    public $funeral_date;
    public $funeral_receiver_name;
    public $funeral_receiver_birthday;
    public $funeral_receiver_cause_of_death;
    public $funeral_receiver_death_date;
    public $funeral_receiver_photograph;
    public $funeral_contractor_id;
    public $funeral_notes;
    public $funeral_status;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->package_id = $args['package_id'] ?? '';
        $this->coffins = $args['coffins'] ?? '';
        $this->urns = $args['urns'] ?? '';
        $this->services = $args['services'] ?? '';
        $this->complements = $args['complements'] ?? '';
        $this->chapels = $args['chapels'] ?? '';
        $this->hearses = $args['hearses'] ?? '';
        $this->cemeteries = $args['cemeteries'] ?? '';
        $this->crematories = $args['crematories'] ?? '';
        $this->funeral_price = $args['funeral_price'] ?? '';
        $this->funeral_cost = $args['funeral_cost'] ?? '';
        $this->funeral_date = $args['funeral_date'] ?? '';
        $this->funeral_receiver_name = $args['funeral_receiver_name'] ?? '';
        $this->funeral_receiver_birthday = $args['funeral_receiver_birthday'] ?? '';
        $this->funeral_receiver_cause_of_death = $args['funeral_receiver_cause_of_death'] ?? '';
        $this->funeral_receiver_death_date = $args['funeral_receiver_death_date'] ?? '';
        $this->funeral_receiver_photograph = $args['funeral_receiver_photograph'] ?? '';
        $this->funeral_contractor_id = $args['funeral_contractor_id'] ?? '';
        $this->funeral_notes = $args['funeral_notes'] ?? '';
        $this->funeral_status = $args['funeral_status'] ?? '';
    }

    public function validate() {
        if(!$this->coffins) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->urns) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->services) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->complements) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->chapels) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->cemeteries) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->crematories) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_price) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_cost) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_date) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_receiver_name) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_receiver_birthday) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_receiver_cause_of_death) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_receiver_death_date) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_receiver_photograph) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->funeral_contractor_id) {
            self::$alerts['error'][] = 'La selección de contratante es obligatoria';
        }
        if(!$this->funeral_notes) {
            self::$alerts['error'][] = 'La selección de notas es obligatoria';
        }
        if(!$this->funeral_status) {
            self::$alerts['error'][] = 'La selección de estado es obligatoria';
        }
    
        return self::$alerts;
    }
}

?>