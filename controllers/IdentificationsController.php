<?php

namespace Controllers;

use Classes\Pagination;
use Model\Identification;
use Model\OpsCountry;
use Model\Service;
use MVC\Router;
use Model\SpecialProgram;
use Model\User;

class IdentificationsController {
    
    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $countries = OpsCountry::allWhere('status', 'ACTIVE');

            $user = User::find($_SESSION['id']);
            $currentPage = $_GET['page'];
            $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

            if(!$currentPage || $currentPage < 1){
                header('Location: /dashboard/identifications?page=1');
            }

            $totalRecords = Identification::countRecords('status', 'ACTIVE');
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage, $recordsPerPage, $totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/identifications?page=1');
            }

            $identifications = Identification::paginateStatus($recordsPerPage,$pagination->calculateOffset(), 'ACTIVE');

            $router->render('admin/identifications/index',[
                'title' => 'Identificaciones',
                'identifications' => $identifications,
                'pagination' => $pagination->pagination(),
                'user' => $user,
                'countries' => $countries
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
            $countries = OpsCountry::allWhere('status', 'ACTIVE');
            $alerts = [];
            $identification = new Identification();

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $identification->sincronize($_POST);
                $alerts = $identification->validate();

                if(empty($alerts)){
                    $result = $identification->saveElement();
                    if($result){
                        header('Location: /dashboard/identifications');
                    }
                }
            }

            $router->render('admin/identifications/create',[
                'title' => 'Registrar identificación',
                'alerts' => $alerts,
                'identification' => $identification,
                'user' => $user,
                'countries' => $countries
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
            $countries = OpsCountry::allWhere('status', 'ACTIVE');
            $alerts = [];
            $id = $_GET['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);
            
            if(!$id){
                header('Location: /dashboard/identifications');
            }

            $identification = Identification::find($id);

            if(!$identification || !$identification instanceof Identification){
                header('Location: /dashboard/identifications');
            } else{
                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $identification->sincronize($_POST);
                    $alerts = $identification->validate();

                    if(empty($alerts)){
                        $result = $identification->saveElement();
                        if($result){
                            header('Location: /dashboard/identifications');
                        }
                    }
                }

                $router->render('admin/identifications/edit',[
                    'title' => 'Editar identificación',
                    'alerts' => $alerts,
                    'identification' => $identification ?? null,
                    'user' => $user,
                    'countries' => $countries
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
            $identification = Identification::find($id);
            if(!isset($identification) || !$identification instanceof Identification){
                header('Location: /dashboard/identifications');
            }
            
            $result = $identification->deleteNElement();
            if($result){
                header('Location: /dashboard/identifications');
            }
        }
    }
}