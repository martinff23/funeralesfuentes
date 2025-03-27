<?php

namespace Controllers;

use Model\Hearse;

class APIHearsesController{

    public static function index(){
        $hearses = Hearse::all();
        echo json_encode($hearses);
    }

}