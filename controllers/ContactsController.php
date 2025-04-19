<?php

namespace Controllers;

use Model\Contact;
use Model\Task;
use Model\User;
use MVC\Router;


class ContactsController {
    public static function dashboard(Router $router){
        session_start();

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            $countcontacts = Contact::countRecords('status', 'ACTIVE');
            $counttasks = Task::countRecords('status', 'ACTIVE');
            
            $contacts = Contact::allWhere('status', 'ACTIVE');

            $router->render('admin/contact/index',[
                'title' => 'Solicitudes de contacto',
                'user' => $user,
                'countcontacts' => $countcontacts,
                'counttasks' => $counttasks,
                'contacts' => $contacts
            ]);
        
        } else{
            header('Location: /404');
        }
    }
}