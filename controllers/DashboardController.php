<?php

namespace Controllers;

use Classes\Email;
use Model\Birthday;
use Model\User;
use MVC\Router;


class DashboardController {
    public static function dashboard(Router $router){
        session_start();
        $title = "";
        $url = "";
        $birthdays = new Birthday();

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            $birthdays = $birthdays->order('birthday', 'ASC');

            if(isAuth() && isAdmin()){
                $title = 'Panel de administración';
            } else{
                $title = 'Intranet';
            }

            if(isAuth() && !isAdmin() && isEmployee()){
                $url = 'intranet/index';
            } else{
                $url = 'admin/dashboard/index';
            }

            $router->render($url,[
                'title' => $title,
                'user' => $user,
                'birthdays' => $birthdays
            ]);

        } else{
            // Page 404
        }
    }
}