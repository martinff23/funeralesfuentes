<?php

namespace Controllers;

use Classes\Pagination;
use Model\EmployeeRole;
use Model\Service;
use MVC\Router;
use Model\SpecialProgram;
use Model\User;

class EmployeeRolesController {
    
    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);
            $currentPage = $_GET['page'];
            $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

            if(!$currentPage || $currentPage < 1){
                header('Location: /dashboard/jobroles?page=1');
            }

            $totalRecords = EmployeeRole::countRecords('status', 'ACTIVE');
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/jobroles?page=1');
            }

            $jobroles = EmployeeRole::paginateStatus($recordsPerPage,$pagination->calculateOffset(), 'ACTIVE');

            $router->render('admin/jobroles/index',[
                'title' => 'Roles laborales',
                'jobroles' => $jobroles,
                'pagination' => $pagination->pagination(),
                'user' => $user
            ]);
        } else{
            header('Location: /404');
        }
    }

    public static function create(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            $alerts = [];
            $employeerole = new EmployeeRole();

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $employeerole->sincronize($_POST);
                $alerts = $employeerole->validate();

                if(empty($alerts)){
                    $result = $employeerole->saveElement();
                    if($result){
                        header('Location: /dashboard/jobroles');
                    }
                }
            }

            $router->render('admin/jobroles/create',[
                'title' => 'Registrar posición laboral',
                'alerts' => $alerts,
                'employeerole' => $employeerole,
                'user' => $user
            ]);   
        } else{
            header('Location: /404');
        }
    }

    public static function edit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);
            $alerts = [];
            $id = $_GET['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);
            
            if(!$id){
                header('Location: /dashboard/jobroles');
            }

            $jobrole = EmployeeRole::find($id);

            if(!$jobrole || !$jobrole instanceof EmployeeRole){
                header('Location: /dashboard/jobroles');
            } else{
                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $jobrole->sincronize($_POST);
                    $alerts = $jobrole->validate();

                    if(empty($alerts)){
                        $result = $jobrole->saveElement();
                        if($result){
                            header('Location: /dashboard/jobroles');
                        }
                    }
                }

                $router->render('admin/jobroles/edit',[
                    'title' => 'Editar posición laboral',
                    'alerts' => $alerts,
                    'jobrole' => $jobrole ?? null,
                    'user' => $user
                ]);
            }
        } else{
            header('Location: /404');
        }
    }

    public static function delete(){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        if('POST' === $_SERVER['REQUEST_METHOD']){
            $id = $_POST['id'];
            $jobrole = EmployeeRole::find($id);
            if(!isset($jobrole) || !$jobrole instanceof EmployeeRole){
                header('Location: /dashboard/jobroles');
            }
            
            $result = $jobrole->deleteNElement();
            if($result){
                header('Location: /dashboard/jobroles');
            }
        }
    }
}