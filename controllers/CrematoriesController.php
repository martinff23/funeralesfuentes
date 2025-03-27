<?php

namespace Controllers;

use Classes\Pagination;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Category;
use Model\Crematory;

class CrematoriesController {

    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        $currentPage = $_GET['page'];
        $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

        if(!$currentPage || $currentPage < 1){
            header('Location: /dashboard/crematories?page=1');
        }

        $totalRecords = Crematory::countRecords();
        $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
        
        $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

        if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
            header('Location: /dashboard/crematories?page=1');
        }

        $crematories=Crematory::paginate($recordsPerPage,$pagination->calculateOffset());

        $router->render('admin/crematories/index',[
            'title'=>'Crematorios ofrecidos',
            'crematories'=>$crematories,
            'pagination'=>$pagination->pagination()
        ]);
    }

    public static function create(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','crematory');
        $crematory = new Crematory();

        if('POST'===$_SERVER['REQUEST_METHOD']){
            $imageFolder='../public/build/img/crematories/';
            $savePicture=false;

            // Read image
            $imageName=md5(uniqid(rand(),true));
            if(!empty(trim($_FILES['crematory_image']['tmp_name']))){
                $manager = new ImageManager(new Driver());
                $pngImage=$manager->read(trim($_FILES['crematory_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                $webpImage=$manager->read(trim($_FILES['crematory_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                $_POST['image']=$imageName;
                $savePicture=true;
            }
            
            $_POST['crematory_networks']=json_encode($_POST['crematory_networks'], JSON_UNESCAPED_SLASHES);
            $_POST['crematory_price']=ceil(($_POST['crematory_cost']*1.2)/10)*10;
            $_POST['category']=$_POST['category_id'];
            $crematory->sincronize($_POST);
            $alerts = $crematory->validate();

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

                $result=$crematory->saveElement();
                if($result){
                    header('Location: /dashboard/crematories');
                }
            }
        }

        $router->render('admin/crematories/create',[
            'title'=>'Registrar crematorio',
            'alerts'=>$alerts,
            'crematory'=>$crematory,
            'categories'=>$categories,
            'networks'=>json_decode($crematory->crematory_networks)
        ]);
    }

    public static function edit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','crematory');
        $id=$_GET['id'];
        $id=filter_var($id,FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /dashboard/crematories');
        }

        $crematory = Crematory::find($id);

        if(!$crematory||!$crematory instanceof Crematory){
            header('Location: /dashboard/crematories');
        } else{
            $crematory->currentImage=$crematory->image;

            if('POST'===$_SERVER['REQUEST_METHOD']){
                $imageFolder='../public/build/img/crematories/';
                $savePicture=false;

                // Read image
                $imageName=md5(uniqid(rand(),true));
                if(!empty(trim($_FILES['crematory_image']['tmp_name']))){
                    $manager = new ImageManager(new Driver());
                    $pngImage=$manager->read(trim($_FILES['crematory_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                    $webpImage=$manager->read(trim($_FILES['crematory_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                    $_POST['image']=$imageName;
                    $savePicture=true;
                } else{
                    $_POST['image']=$crematory->currentImage;
                }

                $_POST['crematory_networks']=json_encode($_POST['crematory_networks'], JSON_UNESCAPED_SLASHES);
                $_POST['crematory_price']=ceil(($_POST['crematory_cost']*1.2)/10)*10;
                $_POST['category']=$_POST['category_id'];
                $crematory->sincronize($_POST);
                $alerts=$crematory->validate();

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
    
                    $result=$crematory->saveElement();
                    if($result){
                        header('Location: /dashboard/crematories');
                    }
                }
            }

            $router->render('admin/crematories/edit',[
                'title'=>'Editar crematorio',
                'alerts'=>$alerts,
                'crematory'=>$crematory??null,
                'categories'=>$categories,
                'networks'=>json_decode($crematory->crematory_networks)
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
            $crematory=Crematory::find($id);
            if(!isset($crematory)||!$crematory instanceof Crematory){
                header('Location: /dashboard/crematories');
            }
            
            $result=$crematory->deleteElement();
            if($result){
                header('Location: /dashboard/crematories');
            }
        }
    }
}