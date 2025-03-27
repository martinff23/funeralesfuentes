<?php

namespace Controllers;

use Model\Chapel;

class APIChapelsController{

    public static function index(){
        $chapels = Chapel::all();
        echo json_encode($chapels);
    }

}