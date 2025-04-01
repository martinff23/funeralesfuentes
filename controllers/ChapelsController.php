<?php

namespace Controllers;

use Classes\Pagination;
use Model\Chapel;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Category;

class ChapelsController {

    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        $currentPage = $_GET['page'];
        $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

        if(!$currentPage || $currentPage < 1){
            header('Location: /dashboard/chapels?page=1');
        }

        $totalRecords = Chapel::countRecords();
        $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
        
        $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

        if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
            header('Location: /dashboard/chapels?page=1');
        }

        $chapels=Chapel::paginate($recordsPerPage,$pagination->calculateOffset());

        $router->render('admin/chapels/index',[
            'title'=>'Capillas ofrecidas',
            'chapels'=>$chapels,
            'pagination'=>$pagination->pagination()
        ]);
    }

    public static function create(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $categories=Category::allWhere('type','chapel');
        $chapel = new Chapel();

        if('POST'===$_SERVER['REQUEST_METHOD']){
            $imageFolder = '../public/build/img/chapels/';
            $savePicture = false;
            $imagesToSave = [];
            $imageName = md5(uniqid(rand(),true));

            // Read image
            // if(!empty(trim($_FILES['chapel_image']['tmp_name']))){
            //     $manager = new ImageManager(new Driver());
            //     $pngImage=$manager->read(trim($_FILES['chapel_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
            //     $webpImage=$manager->read(trim($_FILES['chapel_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
            //     $_POST['image']=$imageName;
            //     $savePicture=true;
            // }

            if (!empty($_FILES['chapel_image']['tmp_name'][0])) {
                $manager = new ImageManager(new Driver());
                $tmpNameFiles = $_FILES['chapel_image']['tmp_name'];
                $nameFiles = $_FILES['chapel_image']['name'];
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
            
            $_POST['chapel_networks'] = json_encode($_POST['chapel_networks'], JSON_UNESCAPED_SLASHES);
            $_POST['chapel_price'] = ceil(($_POST['chapel_cost']*1.2)/10)*10;
            $_POST['category'] = $_POST['category_id'];
            $chapel->sincronize($_POST);
            $alerts = $chapel->validate();

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

                $result = $chapel->saveElement();
                if($result){
                    header('Location: /dashboard/chapels');
                }
            }
        }

        $router->render('admin/chapels/create',[
            'title' => 'Registrar capilla',
            'alerts' => $alerts,
            'chapel' => $chapel,
            'categories' => $categories,
            'networks' => json_decode($chapel->chapel_networks)
        ]);
    }

    public static function edit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts=[];
        $flag = false;
        $differentImages = [];
        $categories = Category::allWhere('type','chapel');
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);

        if(!$id){
            header('Location: /dashboard/chapels');
        }

        $chapel = Chapel::find($id);

        if(!$chapel||!$chapel instanceof Chapel){
            header('Location: /dashboard/chapels');
        } else{
            if(str_contains($chapel->image, ",")){
                $flag = true; // true if multiple images, false if only one
                $differentImages = explode(",", $chapel->image);
                foreach($differentImages as $differentImage){
                    if(!str_contains($differentImage, "_")){
                        $chapel->currentImage=$differentImage;
                    }
                } // Para usar en el swiper
            } else{
                $chapel->currentImage=$chapel->image;
            }

            if('POST'===$_SERVER['REQUEST_METHOD']){
                $imageFolder = '../public/build/img/chapels/';
                $savePicture = false;
                $imagesToSave = [];
                $imageName = md5(uniqid(rand(),true));

                // Read image
                // if(!empty(trim($_FILES['chapel_image']['tmp_name']))){
                //     $manager = new ImageManager(new Driver());
                //     $pngImage=$manager->read(trim($_FILES['chapel_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                //     $webpImage=$manager->read(trim($_FILES['chapel_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                //     $_POST['image']=$imageName;
                //     $savePicture=true;
                // } else{
                //     $_POST['image']=$chapel->currentImage;
                // }

                if (!empty($_FILES['chapel_image']['tmp_name'][0])) {
                    $manager = new ImageManager(new Driver());
                    $tmpNameFiles = $_FILES['chapel_image']['tmp_name'];
                    $nameFiles = $_FILES['chapel_image']['name'];
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
                    $_POST['image'] = $chapel->image;
                }

                $_POST['chapel_networks'] = json_encode($_POST['chapel_networks'], JSON_UNESCAPED_SLASHES);
                $_POST['chapel_price'] = ceil(($_POST['chapel_cost']*1.2)/10)*10;
                $_POST['category'] = $_POST['category_id'];
                $chapel->sincronize($_POST);
                $alerts = $chapel->validate();

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
    
                    $result = $chapel->saveElement();
                    if($result){
                        header('Location: /dashboard/chapels');
                    }
                }
            }

            $router->render('admin/chapels/edit',[
                'title'=>'Editar capilla',
                'alerts'=>$alerts,
                'chapel'=>$chapel??null,
                'categories'=>$categories,
                'networks'=>json_decode($chapel->chapel_networks),
                'flag' => $flag,
                'differentImages' => $differentImages
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
            $chapel=Chapel::find($id);
            if(!isset($chapel)||!$chapel instanceof Chapel){
                header('Location: /dashboard/chapels');
            }
            
            $result=$chapel->deleteElement();
            if($result){
                header('Location: /dashboard/chapels');
            }
        }
    }
}