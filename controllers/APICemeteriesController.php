<?php

namespace Controllers;

use Model\Cemetery;

class APICemeteriesController{

    public static function index(){
        $cemeteries = Cemetery::all();
        echo json_encode($cemeteries);
    }

}