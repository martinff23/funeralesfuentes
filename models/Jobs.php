<?php

namespace Model;

class Jobs extends ActiveRecord{
    protected static $table = 'jobs';
    protected static $databaseColumns = ['id', 'package_id', 'coffins', 'urns', 'services', 'complements', 'chapels', 'hearses', 'cemeteries', 'crematories', 'job_price', 'job_cost', 'job_date', 'job_receiver_name', 'job_receiver_birthday', 'job_receiver_cause_of_death', 'job_receiver_death_date', 'job_receiver_photograph', 'job_contractor_id', 'job_notes', 'job_status'];

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
    public $job_price;
    public $job_cost;
    public $job_date;
    public $job_receiver_name;
    public $job_receiver_birthday;
    public $job_receiver_cause_of_death;
    public $job_receiver_death_date;
    public $job_receiver_photograph;
    public $job_contractor_id;
    public $job_notes;
    public $job_status;

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
        $this->job_price = $args['job_price'] ?? '';
        $this->job_cost = $args['job_cost'] ?? '';
        $this->job_date = $args['job_date'] ?? '';
        $this->job_receiver_name = $args['job_receiver_name'] ?? '';
        $this->job_receiver_birthday = $args['job_receiver_birthday'] ?? '';
        $this->job_receiver_cause_of_death = $args['job_receiver_cause_of_death'] ?? '';
        $this->job_receiver_death_date = $args['job_receiver_death_date'] ?? '';
        $this->job_receiver_photograph = $args['job_receiver_photograph'] ?? '';
        $this->job_contractor_id = $args['job_contractor_id'] ?? '';
        $this->job_notes = $args['job_notes'] ?? '';
        $this->job_status = $args['job_status'] ?? '';
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
        if(!$this->job_price) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_cost) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_date) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_receiver_name) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_receiver_birthday) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_receiver_cause_of_death) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_receiver_death_date) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_receiver_photograph) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_contractor_id) {
            self::$alerts['error'][] = 'La selección de contratante es obligatoria';
        }
        if(!$this->job_notes) {
            self::$alerts['error'][] = 'La selección de notas es obligatoria';
        }
        if(!$this->job_status) {
            self::$alerts['error'][] = 'La selección de estado es obligatoria';
        }
    
        return self::$alerts;
    }
}

?>