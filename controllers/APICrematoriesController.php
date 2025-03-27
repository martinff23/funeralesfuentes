<?php

namespace Controllers;

use Model\Crematory;

class APICrematoriesController{

    public static function index(){
        $crematories = Crematory::all();
        echo json_encode($crematories);
    }

}