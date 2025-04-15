<?php

namespace Controllers;

use Classes\Pagination;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\File;
use Model\User;

class FilesController {
    
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
                header('Location: /dashboard/files?page=1');
            }

            $totalRecords = File::countRecords('status', 'ACTIVE');
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/files?page=1');
            }

            $files = File::paginateStatus($recordsPerPage,$pagination->calculateOffset(), 'ACTIVE');
            
            $router->render('admin/files/index',[
                'title' => 'Archivos del negocio',
                'files' => $files,
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
            $file = new File();

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $route = $_POST['file_route'];
                $_POST['route'] = $_POST['file_route'];
                $_POST['real_name'] = $_FILES['file_image']['name'];
                $imageFolder = 'public/build/img/'.$route.'/';
                $savePicture = false;
                $imageName = md5(uniqid(rand(),true));

                // Read image
                if(!empty(trim($_FILES['file_image']['tmp_name']))){
                    $manager = new ImageManager(new Driver());
                    $pngImage = $manager->read(trim($_FILES['file_image']['tmp_name']))->resize(800,600)->encode(new PngEncoder(80));
                    $webpImage = $manager->read(trim($_FILES['file_image']['tmp_name']))->resize(800,600)->encode(new WebpEncoder(80));
                    $_POST['image'] = $imageName;
                    $savePicture = true;
                }
                
                $file->sincronize($_POST);
                $alerts = $file->validate();

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

                    $result = $file->saveElement();
                    if($result){
                        header('Location: /dashboard/files');
                    }
                }
            }

            $router->render('admin/files/create',[
                'title' => 'Guardar archivo',
                'alerts' => $alerts,
                'file' => $file,
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
                header('Location: /dashboard/files');
            }

            $file = File::find($id);

            if(!$file || !$file instanceof File){
                header('Location: /dashboard/files');
            } else{
                $file->currentImage=$file->image;

                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $route = $_POST['file_route'];
                    $_POST['route'] = $_POST['file_route'];
                    $_POST['real_name'] = $_FILES['file_image']['name'];
                    $imageFolder = 'public/build/img/'.$route.'/';
                    $savePicture = false;
                    $imageName = md5(uniqid(rand(),true));

                    // Read image
                    if(!empty(trim($_FILES['file_image']['tmp_name']))){
                        $manager = new ImageManager(new Driver());
                        $pngImage = $manager->read(trim($_FILES['file_image']['tmp_name']))->resize(800,600)->encode(new PngEncoder(80));
                        $webpImage = $manager->read(trim($_FILES['file_image']['tmp_name']))->resize(800,600)->encode(new WebpEncoder(80));
                        $_POST['image'] = $imageName;
                        $savePicture = true;
                    } else{
                        $_POST['image'] = $file->currentImage;
                    }
                    
                    $file->sincronize($_POST);
                    $alerts = $file->validate();

                    if(empty($alerts)){
                        if($savePicture){
                            // Create folder if does not exist
                            if(!is_dir(trim($imageFolder))){
                                mkdir(trim($imageFolder),0777,true);
                            }
        
                            // Make the foldar ALWAYS writable
                            chmod($imageFolder, 0777);

                            $oldPngPath  = $imageFolder . $file->currentImage . '.png';
                            $oldWebpPath = $imageFolder . $file->currentImage . '.webp';
                            
                            if (file_exists($oldPngPath)) {
                                unlink($oldPngPath);
                            }
                            if (file_exists($oldWebpPath)) {
                                unlink($oldWebpPath);
                            }
        
                            // Put image on server
                            $pngImage->save(trim($imageFolder.$imageName).'.png');
                            $webpImage->save(trim($imageFolder.$imageName).'.webp');
                        }
        
                        $result = $file->saveElement();
                        if($result){
                            header('Location: /dashboard/files');
                        }
                    }
                }

                $router->render('admin/files/edit',[
                    'title' => 'Editar archivo',
                    'alerts' => $alerts,
                    'file' => $file ?? null,
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
            $file = File::find($id);
            if(!isset($file) || !$file instanceof File){
                header('Location: /dashboard/files');
            }
            
            $result = $file->deleteNElement();
            if($result){
                header('Location: /dashboard/files');
            }
        }
    }
}