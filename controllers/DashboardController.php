<?php

namespace Controllers;

use Classes\Email;
use Model\Birthday;
use Model\Contact;
use Model\Task;
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
            $countcontacts = Contact::countRecords('status', 'ACTIVE');
            $counttasks = Task::countRecords('status', 'ACTIVE');

            if("1" === $user->registerOrigin){
                header('Location: /dashboard/users/reset');
            } else{
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
                    'birthdays' => $birthdays,
                    'countcontacts' => $countcontacts,
                    'counttasks' => $counttasks
                ]);
            }
        } else{
            header('Location: /404');
        }
    }

    public static function usersMenu(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);            
            $router->render('admin/usersMenu',[
                'user' => $user
            ]);
        } else{
            header('Location: /404');
        }
    }

    public static function workElementsMenu(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);            
            $router->render('admin/workElementsMenu',[
                'user' => $user
            ]);
        } else{
            header('Location: /404');
        }
    }

    public static function recordElementsMenu(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);            
            $router->render('admin/recordElementsMenu',[
                'user' => $user
            ]);
        } else{
            header('Location: /404');
        }
    }

    public static function alliancesMenu(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);            
            $router->render('admin/alliancesMenu',[
                'user' => $user
            ]);
        } else{
            header('Location: /404');
        }
    }
}