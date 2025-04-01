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
            // if(!empty(trim($_FILES['service_image']['tmp_name']))){
            //     $manager = new ImageManager(new Driver());
            //     $pngImage=$manager->read(trim($_FILES['service_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
            //     $webpImage=$manager->read(trim($_FILES['service_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
            //     $_POST['image']=$imageName;
            //     $savePicture=true;
            // }

            if (!empty($_FILES['service_image']['tmp_name'][0])) {
                $manager = new ImageManager(new Driver());
                $tmpNameFiles = $_FILES['service_image']['tmp_name'];
                $nameFiles = $_FILES['service_image']['name'];
                $imagesToSave = [];
                $imageNames = [];
            
                foreach ($tmpNameFiles as $key => $tmpNameFile) {
                    $tmpNameFile = trim($tmpNameFile);
            
                    if (empty($tmpNameFile)) {
                        continue;
                    }
            
                    $image = $manager->read($tmpNameFile)->cover(800, 600);
                    $pngImage = $image->encode(new PngEncoder(80));
                    $webpImage = $image->encode(new WebpEncoder(80));
            
                    // Generar nombre
                    $realName = strtoupper(pathinfo($nameFiles[$key], PATHINFO_FILENAME));
                    $suffix = '';
                    if (str_contains($realName, "_")) {
                        [$prefix, $suffix] = explode("_", $realName, 2);
                    }
            
                    $newImageName = $suffix ? "{$imageName}_{$suffix}" : $imageName;
            
                    // Guardar en array temporal
                    $imagesToSave[] = [
                        'name' => $newImageName,
                        'png'  => $pngImage,
                        'webp' => $webpImage
                    ];
            
                    $imageNames[] = $newImageName;
                }
            
                $_POST['image'] = implode(',', $imageNames);
                $savePicture = true;
            }
            
            $_POST['service_price']=ceil(($_POST['service_cost']*1.2)/10)*10;
            $_POST['category_id']=$_POST['category_id'];
            $service->sincronize($_POST);
            $alerts = $service->validate();

            if(empty($alerts)){
                // if($savePicture){
                //     // Create folder if does not exist
                //     if(!is_dir(trim($imageFolder))){
                //         mkdir(trim($imageFolder),0777,true);
                //     }

                //     // Make the foldar ALWAYS writable
                //     chmod($imageFolder, 0777);

                //     // Put image on server
                //     $pngImage->save(trim($imageFolder.$imageName).'.png');
                //     $webpImage->save(trim($imageFolder.$imageName).'.webp');
                // }

                if($savePicture){
                    // Create folder if does not exist
                    if(!is_dir(trim($imageFolder))){
                        mkdir(trim($imageFolder),0777,true);
                    }

                    // Make the foldar ALWAYS writable
                    chmod($imageFolder, 0777);

                    // Put image on server
                    foreach($imagesToSave as $imageToSave){
                        $currentPngImage = $imageToSave['png'];
                        $currentWebpImage = $imageToSave['webp'];
                        $currentPngImage->save(trim($imageFolder.$imageToSave['name']).'.png');
                        $currentWebpImage->save(trim($imageFolder.$imageToSave['name']).'.webp');
                    }
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
        
        $alerts = [];
        $flag = false;
        $differentImages = [];
        $categories = Category::allWhere('type','service');
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        
        if(!$id){
            header('Location: /dashboard/services');
        }

        $service = Service::find($id);

        if(!$service||!$service instanceof Service){
            header('Location: /dashboard/services');
        } else{
            if(str_contains($service->image, ",")){
                $flag = true; // true if multiple images, false if only one
                $differentImages = explode(",", $service->image);
                foreach($differentImages as $differentImage){
                    if(!str_contains($differentImage, "_")){
                        $service->currentImage=$differentImage;
                    }
                } // Para usar en el swiper
            } else{
                $service->currentImage=$service->image;
            }

            if('POST'===$_SERVER['REQUEST_METHOD']){
                $imageFolder='../public/build/img/services/';
                $savePicture=false;
                $imagesToSave = [];
                $imageName=md5(uniqid(rand(),true));

                // Read image
                // if(!empty(trim($_FILES['service_image']['tmp_name']))){
                //     $manager = new ImageManager(new Driver());
                //     $pngImage=$manager->read(trim($_FILES['service_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                //     $webpImage=$manager->read(trim($_FILES['service_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                //     $_POST['image']=$imageName;
                //     $savePicture=true;
                // } else{
                //     $_POST['image']=$service->currentImage;
                // }

                if (!empty($_FILES['service_image']['tmp_name'][0])) {
                    $manager = new ImageManager(new Driver());
                    $tmpNameFiles = $_FILES['service_image']['tmp_name'];
                    $nameFiles = $_FILES['service_image']['name'];
                    $imagesToSave = [];
                    $imageNames = [];
                
                    foreach ($tmpNameFiles as $key => $tmpNameFile) {
                        $tmpNameFile = trim($tmpNameFile);
                
                        if (empty($tmpNameFile)) {
                            continue;
                        }
                
                        $image = $manager->read($tmpNameFile)->cover(800, 600);
                        $pngImage = $image->encode(new PngEncoder(80));
                        $webpImage = $image->encode(new WebpEncoder(80));
                
                        // Generar nombre
                        $realName = strtoupper(pathinfo($nameFiles[$key], PATHINFO_FILENAME));
                        $suffix = '';
                        if (str_contains($realName, "_")) {
                            [$prefix, $suffix] = explode("_", $realName, 2);
                        }
                
                        $newImageName = $suffix ? "{$imageName}_{$suffix}" : $imageName;
                
                        // Guardar en array temporal
                        $imagesToSave[] = [
                            'name' => $newImageName,
                            'png'  => $pngImage,
                            'webp' => $webpImage
                        ];
                
                        $imageNames[] = $newImageName;
                    }
                
                    $_POST['image'] = implode(',', $imageNames);
                    $savePicture = true;
                } else {
                    $_POST['image'] = $service->image;
                }

                $_POST['service_price'] = ceil(($_POST['service_cost']*1.2)/10)*10;
                $_POST['category_id'] = $_POST['category_id'];
                $service->sincronize($_POST);
                $alerts = $service->validate();

                if(empty($alerts)){
                    // if($savePicture){
                    //     // Create folder if does not exist
                    //     if(!is_dir(trim($imageFolder))){
                    //         mkdir(trim($imageFolder),0777,true);
                    //     }
    
                    //     // Make the foldar ALWAYS writable
                    //     chmod($imageFolder, 0777);
    
                    //     // Put image on server
                    //     $pngImage->save(trim($imageFolder.$imageName).'.png');
                    //     $webpImage->save(trim($imageFolder.$imageName).'.webp');
                    // }

                    if($savePicture){
                        // Create folder if does not exist
                        if(!is_dir(trim($imageFolder))){
                            mkdir(trim($imageFolder),0777,true);
                        }
    
                        // Make the foldar ALWAYS writable
                        chmod($imageFolder, 0777);

                        // Delete previous images before saving the new ones
                        if (isset($flag) && $flag && !empty($differentImages)) {
                            foreach ($differentImages as $oldImageName) {
                                $oldPngPath  = $imageFolder . $oldImageName . '.png';
                                $oldWebpPath = $imageFolder . $oldImageName . '.webp';
                    
                                if (file_exists($oldPngPath)) {
                                    unlink($oldPngPath);
                                }
                                if (file_exists($oldWebpPath)) {
                                    unlink($oldWebpPath);
                                }
                            }
                        }
    
                        // Put image on server
                        foreach($imagesToSave as $imageToSave){
                            $currentPngImage = $imageToSave['png'];
                            $currentWebpImage = $imageToSave['webp'];
                            $currentPngImage->save(trim($imageFolder.$imageToSave['name']).'.png');
                            $currentWebpImage->save(trim($imageFolder.$imageToSave['name']).'.webp');
                        }
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