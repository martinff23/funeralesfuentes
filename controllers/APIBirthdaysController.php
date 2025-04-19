<?php

namespace Controllers;

use Model\Birthday;

class APIBirthdaysController{

    public static function index(){
        $birthdays = Birthday::order('birthday', 'ASC');
        echo json_encode($birthdays);
    }

}