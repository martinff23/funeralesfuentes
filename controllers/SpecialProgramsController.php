<?php

namespace Controllers;

use Classes\Pagination;
use Model\Service;
use MVC\Router;
use Model\SpecialProgram;
use Model\User;

class SpecialProgramsController {
    
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
                header('Location: /dashboard/specialprograms?page=1');
            }

            $totalRecords = SpecialProgram::countRecords('status', 'ACTIVE');
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/specialprograms?page=1');
            }

            $specialprograms = SpecialProgram::paginateStatus($recordsPerPage,$pagination->calculateOffset(), 'ACTIVE');

            $router->render('admin/specialprograms/index',[
                'title' => 'Programas especiales',
                'specialprograms' => $specialprograms,
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
            $specialProgram = new SpecialProgram;

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $specialProgram->sincronize($_POST);
                $alerts = $specialProgram->validate();

                if(empty($alerts)){
                    $result = $specialProgram->saveElement();
                    if($result){
                        header('Location: /dashboard/specialprograms');
                    }
                }
            }

            $router->render('admin/specialprograms/create',[
                'title' => 'Registrar programa',
                'alerts' => $alerts,
                'specialprogram' => $specialProgram,
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
                header('Location: /dashboard/specialprograms');
            }

            $specialProgram = SpecialProgram::find($id);

            if(!$specialProgram || !$specialProgram instanceof SpecialProgram){
                header('Location: /dashboard/specialprograms');
            } else{
                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $specialProgram->sincronize($_POST);
                    $alerts = $specialProgram->validate();

                    if(empty($alerts)){
                        $result = $specialProgram->saveElement();
                        if($result){
                            header('Location: /dashboard/specialprograms');
                        }
                    }
                }

                $router->render('admin/specialprograms/edit',[
                    'title' => 'Editar programa',
                    'alerts' => $alerts,
                    'specialprogram' => $specialProgram ?? null,
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
            $specialprogram = SpecialProgram::find($id);
            if(!isset($specialprogram) || !$specialprogram instanceof SpecialProgram){
                header('Location: /dashboard/specialprograms');
            }
            
            $result = $specialprogram->deleteNElement();
            if($result){
                header('Location: /dashboard/specialprograms');
            }
        }
    }
}