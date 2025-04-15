<?php

namespace Model;

class FinancialsEmployee extends ActiveRecord {
    protected static $table = 'financials_employees';
    protected static $databaseColumns = ['id', 'userId', 'employee_code', 'base_salary', 'bonus', 'commission', 'savings', 'loans'];

    public $id;
    public $userId;
    public $employee_code;
    public $base_salary;
    public $bonus;
    public $commission;
    public $savings;
    public $loans;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->employee_code = $args['employee_code'] ?? '';
        $this->base_salary = $args['base_salary'] ?? '0.00';
        $this->bonus = $args['bonus'] ?? '0.00';
        $this->commission = $args['commission'] ?? '0.00';
        $this->savings = $args['savings'] ?? '0.00';
        $this->loans = $args['loans'] ?? '0.00';
    }
}