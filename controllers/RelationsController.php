<?php

namespace Controllers;

use Classes\Pagination;
use Model\Relation;
use MVC\Router;
use Model\User;

class RelationsController {
    
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
                header('Location: /dashboard/relations?page=1');
            }

            $totalRecords = Relation::countRecords('status', 'ACTIVE');
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/relations?page=1');
            }

            $relations = Relation::paginateStatus($recordsPerPage,$pagination->calculateOffset(), 'ACTIVE');

            $router->render('admin/relations/index',[
                'title' => 'Relaciones de contacto',
                'relations' => $relations,
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
            $relation = new Relation;

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $relation->sincronize($_POST);
                $alerts = $relation->validate();

                if(empty($alerts)){
                    $result = $relation->saveElement();
                    if($result){
                        header('Location: /dashboard/relations');
                    }
                }
            }

            $router->render('admin/relations/create',[
                'title' => 'Registrar relación de contacto',
                'alerts' => $alerts,
                'relation' => $relation,
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
                header('Location: /dashboard/relations');
            }

            $relation = Relation::find($id);

            if(!$relation || !$relation instanceof Relation){
                header('Location: /dashboard/relations');
            } else{
                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $relation->sincronize($_POST);
                    $alerts = $relation->validate();

                    if(empty($alerts)){
                        $result = $relation->saveElement();
                        if($result){
                            header('Location: /dashboard/relations');
                        }
                    }
                }

                $router->render('admin/relations/edit',[
                    'title' => 'Editar país',
                    'alerts' => $alerts,
                    'relation' => $relation ?? null,
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
            $relation = Relation::find($id);
            if(!isset($relation) || !$relation instanceof Relation){
                header('Location: /dashboard/relations');
            }
            
            $result = $relation->deleteNElement();
            if($result){
                header('Location: /dashboard/relations');
            }
        }
    }
}