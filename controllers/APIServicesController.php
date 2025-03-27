<?php

namespace Controllers;

use Model\Service;

class APIServicesController{

    public static function index(){
        $services = Service::all();
        echo json_encode($services);
    }

}