<?php

namespace Controllers;

use Classes\Email;
use Model\Birthday;
use Model\User;
use MVC\Router;


class IntranetController {
    public static function dashboard(Router $router){
        session_start();
        $user = new User;
        $birthdays = new Birthday;

        if(isset($_SESSION['id'])){
            $user = $user->find($_SESSION['id']);
            $birthdays = $birthdays->order('birthday', 'ASC');

            debug($birthdays);

            $router->render('intranet/index',[
                'user' => $user,
                'birthdays' => $birthdays
            ]);
        } else{
            // Page 404
        }
    }
}