<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;


class CotizationsController {
    public static function dashboard(Router $router){
        $router->render('admin/cotization/index',[
            'title'=>'Cotizaciones'
        ]);
    }
}