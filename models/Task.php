<?php

namespace Model;

class Task extends ActiveRecord{
    protected static $table = 'employee_tasks';
    protected static $databaseColumns = ['id', 'userId', 'task_type', 'title', 'requirement', 'notes', 'underlyingId', 'status', 'assigner', 'entered_datetime', 'closed_datetime', 'priority', 'deadline'];

    public $id;
    public $userId;
    public $task_type;
    public $title;
    public $requirement;
    public $notes;
    public $underlyingId;
    public $status;
    public $assigner;
    public $entered_datetime;
    public $closed_datetime;
    public $priority;
    public $deadline;
    
    public $assigner_info;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->userId = $args['userId'] ?? 0;
        $this->task_type = $args['task_type'] ?? '';
        $this->title = $args['title'] ?? '';
        $this->requirement = $args['requirement'] ?? '';
        $this->notes = $args['notes'] ?? '';
        $this->underlyingId = $args['underlyingId'] ?? 0;
        $this->status = $args['status'] ?? 'ACTIVE';
        $this->assigner = $args['assigner'] ?? 0;
        $this->entered_datetime = $args['entered_datetime'] ?? '';
        $this->closed_datetime = $args['closed_datetime'] ?? '';
        $this->priority = $args['priority'] ?? '';
        $this->deadline = $args['deadline'] ?? '';
    }

    public function validate() {
        if(!$this->userId) {
            self::$alerts['error'][] = 'El usuario es obligatorio';
        }
        if(!$this->title) {
            self::$alerts['error'][] = 'El titulo es obligatorio';
        }
        if(!$this->requirement) {
            self::$alerts['error'][] = 'El requerimiento es obligatorio';
        }
        if(!$this->notes) {
            self::$alerts['error'][] = 'Las notas son obligatorias';
        }
        if(!$this->task_type) {
            self::$alerts['error'][] = 'El tipo de tarea es obligatorio';
        }
        if(!$this->underlyingId) {
            self::$alerts['error'][] = 'El identificador de tarea es obligatorio';
        }
        if(!$this->priority) {
            self::$alerts['error'][] = 'La prioridad es obligatoria';
        }
        if(!$this->deadline) {
            self::$alerts['error'][] = 'El límite de tiempo es obligatorio';
        }
    }
}

?>