<?php

namespace Model;

class EmployeeRole extends ActiveRecord {
    protected static $table = 'employee_roles';
    protected static $databaseColumns = ['id', 'name', 'visual_name', 'min_salary', 'max_salary', 'status'];

    public $id;
    public $name;
    public $visual_name;
    public $min_salary;
    public $max_salary;
    public $status;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->visual_name = $args['visual_name'] ?? '';
        $this->min_salary = $args['min_salary'] ?? '0.00';
        $this->max_salary = $args['max_salary'] ?? '0.00';
        $this->status = $args['status'] ?? 'ACTIVE';
    }
    
    public function validate() {
        if('none'===strtolower($this->name)){
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if('none'===strtolower($this->visual_name)){
            self::$alerts['error'][] = 'El nombre visual es obligatorio';
        }
        if(!$this->min_salary){
            self::$alerts['error'][] = 'El salario mínimo de la posición es obligatorio';
        }
        if(!$this->max_salary){
            self::$alerts['error'][] = 'El salario máximo de la posición es obligatorio';
        }
        if('none'===strtolower($this->status)){
            self::$alerts['error'][] = 'El estado es obligatorio';
        }

        return self::$alerts;
    }
}