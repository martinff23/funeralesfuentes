<?php

namespace Model;

class Employee extends ActiveRecord {
    protected static $table = 'employees';
    protected static $databaseColumns = ['id', 'userId', 'employee_code', 'gender', 'movility_chance', 'disability', 'special_program_id', 'positionId', 'branchId', 'start_date', 'end_date', 'status', 'identification_type', 'identification_value', 'social_security_id', 'emergency_contact', 'emergency_contact_name', 'emergency_contact_relation'];

    public $id;
    public $userId;
    public $employee_code;
    public $gender;
    public $movility_chance;
    public $disability;
    public $special_program_id;
    public $positionId;
    public $branchId;
    public $start_date;
    public $end_date;
    public $status;
    public $identification_type;
    public $identification_value;
    public $social_security_id;
    public $emergency_contact;
    public $emergency_contact_name;
    public $emergency_contact_relation;

    
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->employee_code = $args['employee_code'] ?? '';
        $this->gender = $args['gender'] ?? '';
        $this->movility_chance = $args['movility_chance'] ?? '';
        $this->disability = $args['disability'] ?? '';
        $this->special_program_id = $args['special_program_id'] ?? null;
        $this->positionId = $args['positionId'] ?? null;
        $this->branchId = $args['branchId'] ?? null;
        $this->start_date = $args['start_date'] ?? '';
        $this->end_date = $args['end_date'] ?? '9999/12/12';
        $this->status = $args['status'] ?? 'ACTIVE';
        $this->identification_type = $args['identification_type'] ?? '';
        $this->identification_value = $args['identification_value'] ?? '';
        $this->social_security_id = $args['social_security_id'] ?? 'PENDING';
        $this->emergency_contact = $args['emergency_contact'] ?? 'PENDING';
        $this->emergency_contact_name = $args['emergency_contact_name'] ?? 'PENDING';
        $this->emergency_contact_relation = $args['emergency_contact_relation'] ?? 0;
    }

    // Validación para cuentas nuevas
    public function validateEmployee() {
        if(!$this->employee_code) {
            self::$alerts['error'][] = 'El código de empleado es obligatorio';
        }
        if("NONE" === $this->gender) {
            self::$alerts['error'][] = 'El género es obligatorio';
        }
        if("NONE" === $this->movility_chance) {
            self::$alerts['error'][] = 'La disposición de movilidad es obligatoria';
        }
        if("NONE" === $this->disability) {
            self::$alerts['error'][] = 'La discapacidad es obligatoria';
        }
        if("NONE" === $this->special_program_id) {
            self::$alerts['error'][] = 'El programa especial es obligatorio';
        }
        if("NONE" === $this->positionId) {
            self::$alerts['error'][] = 'La posición es obligatoria';
        }
        if("NONE" === $this->branchId) {
            self::$alerts['error'][] = 'La sucursal es obligatoria';
        }
        if(!$this->start_date) {
            self::$alerts['error'][] = 'La fecha de inicio es obligatoria';
        }
        if("NONE" === $this->identification_type) {
            self::$alerts['error'][] = 'El tipo de identificación es obligatorio';
        }
        if(!$this->identification_value) {
            self::$alerts['error'][] = 'El tipo de identificación es obligatorio';
        }

        return self::$alerts;
    }

    public function checkID(){
        if(!$this->userId) {
            self::$alerts['error'][] = 'El usuario es obligatorio';
        }
        return self::$alerts;
    }
}