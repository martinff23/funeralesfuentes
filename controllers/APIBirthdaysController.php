<?php

namespace Controllers;

use Model\Birthday;

class APIBirthdaysController{

    public static function index(){
        $cemeteries = Birthday::order('birthday', 'ASC');
        echo json_encode($cemeteries);
    }

}