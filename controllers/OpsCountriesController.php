<?php

namespace Controllers;

use Classes\Pagination;
use Model\OpsCountry;
use MVC\Router;
use Model\User;

class OpsCountriesController {
    
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
                header('Location: /dashboard/opscountries?page=1');
            }

            $totalRecords = OpsCountry::countRecords('status', 'ACTIVE');
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/opscountries?page=1');
            }

            $opscountries = OpsCountry::paginateStatus($recordsPerPage, $pagination->calculateOffset(), 'ACTIVE');

            $router->render('admin/opscountries/index',[
                'title' => 'Países donde operamos',
                'opscountries' => $opscountries,
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
            $opscountry = new OpsCountry();

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $opscountry->sincronize($_POST);
                $alerts = $opscountry->validate();

                if(empty($alerts)){
                    $result = $opscountry->saveElement();
                    if($result){
                        header('Location: /dashboard/opscountries');
                    }
                }
            }

            $router->render('admin/opscountries/create',[
                'title' => 'Registrar país',
                'alerts' => $alerts,
                'opscountry' => $opscountry,
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
                header('Location: /dashboard/opscountries');
            }

            $opscountry = OpsCountry::find($id);

            if(!$opscountry || !$opscountry instanceof OpsCountry){
                header('Location: /dashboard/opscountries');
            } else{
                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $opscountry->sincronize($_POST);
                    $alerts = $opscountry->validate();

                    if(empty($alerts)){
                        $result = $opscountry->saveElement();
                        if($result){
                            header('Location: /dashboard/opscountries');
                        }
                    }
                }

                $router->render('admin/opscountries/edit',[
                    'title' => 'Editar país',
                    'alerts' => $alerts,
                    'opscountry' => $opscountry ?? null,
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
            $opscountry = OpsCountry::find($id);
            if(!isset($opscountry) || !$opscountry instanceof OpsCountry){
                header('Location: /dashboard/opscountries');
            }
            
            $result = $opscountry->deleteNElement();
            if($result){
                header('Location: /dashboard/opscountries');
            }
        }
    }
}