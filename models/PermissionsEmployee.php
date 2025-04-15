<?php

namespace Model;

class PermissionsEmployee extends ActiveRecord {
    protected static $table = 'permissions_employees';
    protected static $databaseColumns = ['id', 'userId', 'employee_code', 'vacations_taken', 'vacations_available', 'sickdays_taken', 'sickdays_available', 'parentleave_taken', 'parentleave_available', 'specialpermissions_count', 'year'];

    public $id;
    public $userId;
    public $employee_code;
    public $vacations_taken;
    public $vacations_available;
    public $sickdays_taken;
    public $sickdays_available;
    public $parentleave_taken;
    public $parentleave_available;
    public $specialpermissions_count;
    public $year;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->employee_code = $args['employee_code'] ?? '';
        $this->vacations_taken = $args['vacations_taken'] ?? '0';
        $this->vacations_available = $args['vacations_available'] ?? '0';
        $this->sickdays_taken = $args['sickdays_taken'] ?? '0';
        $this->sickdays_available = $args['sickdays_available'] ?? '0';
        $this->parentleave_taken = $args['parentleave_taken'] ?? '0';
        $this->parentleave_available = $args['parentleave_available'] ?? '0';
        $this->specialpermissions_count = $args['specialpermissions_count'] ?? '0';
        $this->year = $args['year'] ?? '2025';
    }
}