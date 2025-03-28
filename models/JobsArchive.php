<?php

namespace Model;

class JobsArchive extends ActiveRecord{
    protected static $table = 'jobs';
    protected static $databaseColumns = ['id', 'job_date', 'job_price', 'job_cost', 'job_receiver_name', 'job_receiver_death_date', 'job_contractor_name', 'job_contractor_idN', 'job_notes', 'job_status'];

    public $id;
    public $job_date;
    public $job_price;
    public $job_cost;
    public $job_receiver_name;
    public $job_receiver_death_date;
    public $job_contractor_name;
    public $job_contractor_idN;
    public $job_notes;
    public $job_status;
    
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->job_date = $args['job_date'] ?? '';
        $this->job_price = $args['job_price'] ?? 0.00;
        $this->job_cost = $args['job_cost'] ?? 0.00;
        $this->job_receiver_name = $args['job_receiver_name'] ?? '';
        $this->job_receiver_death_date = $args['job_receiver_death_date'] ?? '';
        $this->job_contractor_name = $args['job_contractor_name'] ?? '';
        $this->job_contractor_idN = $args['job_contractor_idN'] ?? '';
        $this->job_notes = $args['job_notes'] ?? '';
        $this->job_status = $args['job_status'] ?? '';
    }

    public function validate() {
        if(!$this->job_date) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_price) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_cost) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_receiver_name) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_receiver_death_date) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_contractor_name) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_contractor_idN) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_notes) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
        if(!$this->job_status) {
            self::$alerts['error'][] = 'La selección de XXX es obligatoria';
        }
    }
}