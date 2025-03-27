<?php

namespace Controllers;

use Model\Complement;

class APIComplementsController{

    public static function index(){
        $complements = Complement::all();
        echo json_encode($complements);
    }

}