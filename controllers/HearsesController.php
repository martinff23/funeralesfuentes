<?php

namespace Controllers;

use Classes\Pagination;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Category;
use Model\Hearse;

class HearsesController {

    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        $currentPage = $_GET['page'];
        $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

        if(!$currentPage || $currentPage < 1){
            header('Location: /dashboard/hearses?page=1');
        }

        $totalRecords = Hearse::countRecords();
        $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
        
        $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

        if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
            header('Location: /dashboard/hearses?page=1');
        }

        $hearses=Hearse::paginate($recordsPerPage,$pagination->calculateOffset());

        $router->render('admin/hearses/index',[
            'title'=>'Carrozas ofrecidas',
            'hearses'=>$hearses,
            'pagination'=>$pagination->pagination()
        ]);
    }

    public static function create(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','hearse');
        $hearse = new Hearse();

        if('POST'===$_SERVER['REQUEST_METHOD']){
            $imageFolder='../public/build/img/hearses/';
            $savePicture=false;

            // Read image
            $imageName=md5(uniqid(rand(),true));
            if(!empty(trim($_FILES['hearse_image']['tmp_name']))){
                $manager = new ImageManager(new Driver());
                $pngImage=$manager->read(trim($_FILES['hearse_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                $webpImage=$manager->read(trim($_FILES['hearse_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                $_POST['image']=$imageName;
                $savePicture=true;
            }
            
            $_POST['hearse_networks']=json_encode($_POST['hearse_networks'], JSON_UNESCAPED_SLASHES);
            $_POST['hearse_price']=ceil(($_POST['hearse_cost']*1.2)/10)*10;
            $_POST['category']=$_POST['category_id'];
            $hearse->sincronize($_POST);
            $alerts = $hearse->validate();

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

                $result=$hearse->saveElement();
                if($result){
                    header('Location: /dashboard/hearses');
                }
            }
        }

        $router->render('admin/hearses/create',[
            'title'=>'Registrar carroza',
            'alerts'=>$alerts,
            'hearse'=>$hearse,
            'categories'=>$categories,
            'networks'=>json_decode($hearse->hearse_networks)
        ]);
    }

    public static function edit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','hearse');
        $id=$_GET['id'];
        $id=filter_var($id,FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /dashboard/hearses');
        }

        $hearse = Hearse::find($id);

        if(!$hearse||!$hearse instanceof Hearse){
            header('Location: /dashboard/hearses');
        } else{
            $hearse->currentImage=$hearse->image;

            if('POST'===$_SERVER['REQUEST_METHOD']){
                $imageFolder='../public/build/img/hearses/';
                $savePicture=false;

                // Read image
                $imageName=md5(uniqid(rand(),true));
                if(!empty(trim($_FILES['hearse_image']['tmp_name']))){
                    $manager = new ImageManager(new Driver());
                    $pngImage=$manager->read(trim($_FILES['hearse_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                    $webpImage=$manager->read(trim($_FILES['hearse_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                    $_POST['image']=$imageName;
                    $savePicture=true;
                } else{
                    $_POST['image']=$hearse->currentImage;
                }

                $_POST['hearse_networks']=json_encode($_POST['hearse_networks'], JSON_UNESCAPED_SLASHES);
                $_POST['hearse_price']=ceil(($_POST['hearse_cost']*1.2)/10)*10;
                $_POST['category']=$_POST['category_id'];
                $hearse->sincronize($_POST);
                $alerts=$hearse->validate();

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
    
                    $result=$hearse->saveElement();
                    if($result){
                        header('Location: /dashboard/hearses');
                    }
                }
            }

            $router->render('admin/hearses/edit',[
                'title'=>'Editar carroza',
                'alerts'=>$alerts,
                'hearse'=>$hearse??null,
                'categories'=>$categories,
                'networks'=>json_decode($hearse->hearse_networks)
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
            $hearse=Hearse::find($id);
            if(!isset($hearse)||!$hearse instanceof Hearse){
                header('Location: /dashboard/hearses');
            }
            
            $result=$hearse->deleteElement();
            if($result){
                header('Location: /dashboard/hearses');
            }
        }
    }
}