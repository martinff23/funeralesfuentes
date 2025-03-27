<?php

namespace Controllers;

use Classes\Pagination;
use Model\Service;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Category;

class ServicesController {
    
    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        $currentPage = $_GET['page'];
        $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

        if(!$currentPage || $currentPage < 1){
            header('Location: /dashboard/services?page=1');
        }

        $totalRecords = Service::countRecords();
        $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
        
        $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

        if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
            header('Location: /dashboard/services?page=1');
        }

        $services=Service::paginate($recordsPerPage,$pagination->calculateOffset());

        $router->render('admin/services/index',[
            'title'=>'Servicios ofrecidos',
            'services'=>$services,
            'pagination'=>$pagination->pagination()
        ]);
    }

    public static function create(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','service');
        $service = new Service();

        if('POST'===$_SERVER['REQUEST_METHOD']){
            $imageFolder='../public/build/img/services/';
            $savePicture=false;

            // Read image
            $imageName=md5(uniqid(rand(),true));
            if(!empty(trim($_FILES['service_image']['tmp_name']))){
                $manager = new ImageManager(new Driver());
                $pngImage=$manager->read(trim($_FILES['service_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                $webpImage=$manager->read(trim($_FILES['service_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                $_POST['image']=$imageName;
                $savePicture=true;
            }
            
            $_POST['service_price']=ceil(($_POST['service_cost']*1.2)/10)*10;
            $_POST['category_id']=$_POST['category_id'];
            $service->sincronize($_POST);
            $alerts = $service->validate();

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

                $result=$service->saveElement();
                if($result){
                    header('Location: /dashboard/services');
                }
            }
        }

        $router->render('admin/services/create',[
            'title'=>'Registrar servicio ofrecido',
            'alerts'=>$alerts,
            'categories'=>$categories,
            'service'=>$service
        ]);
    }

    public static function edit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','service');
        $id=$_GET['id'];
        $id=filter_var($id,FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /dashboard/services');
        }

        $service = Service::find($id);

        if(!$service||!$service instanceof Service){
            header('Location: /dashboard/services');
        } else{
            $service->currentImage=$service->image;

            if('POST'===$_SERVER['REQUEST_METHOD']){
                $imageFolder='../public/build/img/services/';
                $savePicture=false;

                // Read image
                $imageName=md5(uniqid(rand(),true));
                if(!empty(trim($_FILES['service_image']['tmp_name']))){
                    $manager = new ImageManager(new Driver());
                    $pngImage=$manager->read(trim($_FILES['service_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                    $webpImage=$manager->read(trim($_FILES['service_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                    $_POST['image']=$imageName;
                    $savePicture=true;
                } else{
                    $_POST['image']=$service->currentImage;
                }

                $_POST['service_price']=ceil(($_POST['service_cost']*1.2)/10)*10;
                $_POST['category_id']=$_POST['category_id'];
                $service->sincronize($_POST);
                $alerts=$service->validate();

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
    
                    $result=$service->saveElement();
                    if($result){
                        header('Location: /dashboard/services');
                    }
                }
            }

            $router->render('admin/services/edit',[
                'title'=>'Editar servicio ofrecido',
                'alerts'=>$alerts,
                'categories'=>$categories,
                'service'=>$service??null
            ]);
        }
    }

    public static function delete(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        if('POST'===$_SERVER['REQUEST_METHOD']){
            $id=$_POST['id'];
            $service=Service::find($id);
            if(!isset($service)||!$service instanceof Service){
                header('Location: /dashboard/services');
            }
            
            $result=$service->deleteElement();
            if($result){
                header('Location: /dashboard/services');
            }
        }
    }
}