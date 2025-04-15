<?php

namespace Model;

class RatingsEmployee extends ActiveRecord {
    protected static $table = 'ratings_employees';
    protected static $databaseColumns = ['id', 'userId', 'employee_code', 'internal_rating', 'external_rating', 'rating', 'period'];

    public $id;
    public $userId;
    public $employee_code;
    public $internal_rating;
    public $external_rating;
    public $rating;
    public $period;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->employee_code = $args['employee_code'] ?? '';
        $this->internal_rating = $args['internal_rating'] ?? '0.00';
        $this->external_rating = $args['external_rating'] ?? '0.00';
        $this->rating = $args['rating'] ?? '0.00';
        $this->period = $args['period'] ?? '2025/1';
    }
}