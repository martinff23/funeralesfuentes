<?php

namespace Controllers;

use Classes\Pagination;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Alliance;
use Model\User;

class AlliancesController {
    
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
                header('Location: /dashboard/alliances?page=1');
            }

            $totalRecords = Alliance::countRecords('status', 'ACTIVE');
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/alliances?page=1');
            }

            $alliances = Alliance::paginateStatus($recordsPerPage,$pagination->calculateOffset(), 'ACTIVE');
            
            $router->render('admin/alliances/index',[
                'title' => 'Alianzas del negocio',
                'alliances' => $alliances,
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
            $alliance = new Alliance();

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $imageFolder = '../public/build/img/alliances/';
                $savePicture = false;
                $imageName = md5(uniqid(rand(),true));

                // Read image
                if(!empty(trim($_FILES['alliance_image']['tmp_name']))){
                    $manager = new ImageManager(new Driver());
                    $pngImage = $manager->read(trim($_FILES['alliance_image']['tmp_name']))->resize(800,600)->encode(new PngEncoder(80));
                    $webpImage = $manager->read(trim($_FILES['alliance_image']['tmp_name']))->resize(800,600)->encode(new WebpEncoder(80));
                    $_POST['image'] = $imageName;
                    $savePicture = true;
                }

                $_POST['business_name'] = trim($_POST['alliance_name']);
                $_POST['status'] = trim($_POST['alliance_status']);
                
                $alliance->sincronize($_POST);
                $alerts = $alliance->validate();

                if(empty($alerts)){
                    if($savePicture){
                        // Create folder if does not exist
                        if(!is_dir(trim($imageFolder))){
                            mkdir(trim($imageFolder),0777,true);
                        }

                        // Make the foldar ALWAYS writable
                        chmod($imageFolder, 0777);

                        // Put image on server
                        $pngImage->save(trim($imageFolder.$imageName).'.png');
                        $webpImage->save(trim($imageFolder.$imageName).'.webp');
                    }

                    $result = $alliance->saveElement();
                    if($result){
                        header('Location: /dashboard/alliances');
                    }
                }
            }

            $router->render('admin/alliances/create',[
                'title' => 'Registrar alianza',
                'alerts' => $alerts,
                'alliance' => $alliance,
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
                header('Location: /dashboard/alliances');
            }

            $alliance = Alliance::find($id);

            if(!$alliance || !$alliance instanceof Alliance){
                header('Location: /dashboard/alliances');
            } else{
                $alliance->currentImage=$alliance->image;

                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $imageFolder = '../public/build/img/alliances/';
                    $savePicture = false;
                    $imageName = md5(uniqid(rand(),true));

                    // Read image
                    if(!empty(trim($_FILES['alliance_image']['tmp_name']))){
                        $manager = new ImageManager(new Driver());
                        $pngImage = $manager->read(trim($_FILES['alliance_image']['tmp_name']))->resize(800,600)->encode(new PngEncoder(80));
                        $webpImage = $manager->read(trim($_FILES['alliance_image']['tmp_name']))->resize(800,600)->encode(new WebpEncoder(80));
                        $_POST['image'] = $imageName;
                        $savePicture = true;
                    } else{
                        $_POST['image'] = $alliance->currentImage;
                    }

                    $_POST['business_name'] = trim($_POST['alliance_name']);
                    $_POST['status'] = trim($_POST['alliance_status']);

                    $alliance->sincronize($_POST);
                    $alerts = $alliance->validate();

                    if(empty($alerts)){
                        if($savePicture){
                            // Create folder if does not exist
                            if(!is_dir(trim($imageFolder))){
                                mkdir(trim($imageFolder),0777,true);
                            }
        
                            // Make the foldar ALWAYS writable
                            chmod($imageFolder, 0777);
        
                            // Put image on server
                            $pngImage->save(trim($imageFolder.$imageName).'.png');
                            $webpImage->save(trim($imageFolder.$imageName).'.webp');
                        }
        
                        $result = $alliance->saveElement();
                        if($result){
                            header('Location: /dashboard/alliances');
                        }
                    }
                }

                $router->render('admin/alliances/edit',[
                    'title' => 'Editar alianza',
                    'alerts' => $alerts,
                    'alliance' => $alliance??null,
                    'user' => $user
                ]);
            }   
        } else{
            header('Location: /404');
        }
    }

    public static function delete(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        if('POST' === $_SERVER['REQUEST_METHOD']){
            $id = $_POST['id'];
            $alliance = Alliance::find($id);
            if(!isset($alliance) || !$alliance instanceof Alliance){
                header('Location: /dashboard/alliances');
            }
            
            $result = $alliance->deleteNElement();
            if($result){
                header('Location: /dashboard/alliances');
            }
        }
    }
}