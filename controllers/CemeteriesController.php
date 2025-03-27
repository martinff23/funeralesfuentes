<?php

namespace Controllers;

use Classes\Pagination;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Category;
use Model\Cemetery;

class CemeteriesController {

    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        $currentPage = $_GET['page'];
        $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

        if(!$currentPage || $currentPage < 1){
            header('Location: /dashboard/cemeteries?page=1');
        }

        $totalRecords = Cemetery::countRecords();
        $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
        
        $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

        if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
            header('Location: /dashboard/cemeteries?page=1');
        }

        $cemeteries=Cemetery::paginate($recordsPerPage,$pagination->calculateOffset());

        $router->render('admin/cemeteries/index',[
            'title' => 'Cementerios ofrecidos',
            'cemeteries' => $cemeteries,
            'pagination' => $pagination->pagination()
        ]);
    }

    public static function create(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','cemetery');
        $cemetery = new Cemetery();

        if('POST'===$_SERVER['REQUEST_METHOD']){
            $imageFolder='../public/build/img/cemeteries/';
            $savePicture=false;

            // Read image
            $imageName=md5(uniqid(rand(),true));
            if(!empty(trim($_FILES['cemetery_image']['tmp_name']))){
                $manager = new ImageManager(new Driver());
                $pngImage=$manager->read(trim($_FILES['cemetery_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                $webpImage=$manager->read(trim($_FILES['cemetery_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                $_POST['image']=$imageName;
                $savePicture=true;
            }
            
            $_POST['cemetery_networks']=json_encode($_POST['cemetery_networks'], JSON_UNESCAPED_SLASHES);
            $_POST['cemetery_price']=ceil(($_POST['cemetery_cost']*1.2)/10)*10;
            $_POST['category']=$_POST['category_id'];
            $cemetery->sincronize($_POST);
            $alerts = $cemetery->validate();

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

                $result=$cemetery->saveElement();
                if($result){
                    header('Location: /dashboard/cemeteries');
                }
            }
        }

        $router->render('admin/cemeteries/create',[
            'title' => 'Registrar cementerio',
            'alerts' => $alerts,
            'cemetery' => $cemetery,
            'categories' => $categories,
            'networks' => json_decode($cemetery->cemetery_networks)
        ]);
    }

    public static function edit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','cemetery');
        $id=$_GET['id'];
        $id=filter_var($id,FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /dashboard/cemeteries');
        }

        $cemetery = Cemetery::find($id);

        if(!$cemetery||!$cemetery instanceof Cemetery){
            header('Location: /dashboard/cemeteries');
        } else{
            $cemetery->currentImage=$cemetery->image;

            if('POST'===$_SERVER['REQUEST_METHOD']){
                $imageFolder='../public/build/img/cemeteries/';
                $savePicture=false;

                // Read image
                $imageName=md5(uniqid(rand(),true));
                if(!empty(trim($_FILES['cemetery_image']['tmp_name']))){
                    $manager = new ImageManager(new Driver());
                    $pngImage=$manager->read(trim($_FILES['cemetery_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                    $webpImage=$manager->read(trim($_FILES['cemetery_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                    $_POST['image']=$imageName;
                    $savePicture=true;
                } else{
                    $_POST['image']=$cemetery->currentImage;
                }

                $_POST['cemetery_networks']=json_encode($_POST['cemetery_networks'], JSON_UNESCAPED_SLASHES);
                $_POST['cemetery_price']=ceil(($_POST['cemetery_cost']*1.2)/10)*10;
                $_POST['category']=$_POST['category_id'];
                $cemetery->sincronize($_POST);
                $alerts=$cemetery->validate();

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
    
                    $result=$cemetery->saveElement();
                    if($result){
                        header('Location: /dashboard/cemeteries');
                    }
                }
            }

            $router->render('admin/cemeteries/edit',[
                'title' => 'Editar cementerio',
                'alerts' => $alerts,
                'cemetery' => $cemetery??null,
                'categories' => $categories,
                'networks' => json_decode($cemetery->cemetery_networks)
            ]);
        }
    }

    public static function delete(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        if('POST'===$_SERVER['REQUEST_METHOD']){
            $id = $_POST['id'];
            $cemetery = Cemetery::find($id);
            if(!isset($cemetery)||!$cemetery instanceof Cemetery){
                header('Location: /dashboard/cemeteries');
            }
            
            $result = $cemetery->deleteElement();
            if($result){
                header('Location: /dashboard/cemeteries');
            }
        }
    }
}