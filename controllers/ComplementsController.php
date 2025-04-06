<?php

namespace Controllers;

use Classes\Pagination;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Category;
use Model\Complement;
use Model\User;

class ComplementsController {
    
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
                header('Location: /dashboard/complements?page=1');
            }

            $totalRecords = Complement::countRecords();
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/complements?page=1');
            }

            $complements = Complement::paginate($recordsPerPage,$pagination->calculateOffset());
            
            $router->render('admin/complements/index',[
                'title' => 'Extras ofrecidos',
                'complements' => $complements,
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
            $user = User::find($_SESSION['id']);
            $alerts = [];
            $categories = Category::allWhere('type','complement');
            $complement = new Complement;

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $imageFolder = '../public/build/img/complements/';
                $savePicture = false;
                $imagesToSave = [];
                $imageName = md5(uniqid(rand(),true));

                if (!empty($_FILES['complement_image']['tmp_name'][0])) {
                    $manager = new ImageManager(new Driver());
                    $tmpNameFiles = $_FILES['complement_image']['tmp_name'];
                    $nameFiles = $_FILES['complement_image']['name'];
                    $imagesToSave = [];
                    $imageNames = [];
                
                    foreach ($tmpNameFiles as $key => $tmpNameFile) {
                        $tmpNameFile = trim($tmpNameFile);
                
                        if (empty($tmpNameFile)) {
                            continue;
                        }
                
                        $image = $manager->read($tmpNameFile)->resize(800, 600);
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
                            'png' => $pngImage,
                            'webp' => $webpImage
                        ];
                
                        $imageNames[] = $newImageName;
                    }
                
                    $_POST['image'] = implode(',', $imageNames);
                    $savePicture = true;
                }
                
                $_POST['complement_networks'] = json_encode($_POST['complement_networks'], JSON_UNESCAPED_SLASHES);
                $_POST['complement_price'] = ceil(($_POST['complement_cost']*1.2)/10)*10;
                $_POST['category'] = $_POST['category_id'];
                $complement->sincronize($_POST);
                $alerts = $complement->validate();

                if(empty($alerts)){
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

                    $result = $complement->saveElement();
                    if($result){
                        header('Location: /dashboard/complements');
                    }
                }
            }

            $router->render('admin/complements/create',[
                'title' => 'Registrar extra ofrecido',
                'alerts' => $alerts,
                'complement' => $complement,
                'categories' => $categories,
                'networks' => json_decode($complement->complement_networks),
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
            $flag = false;
            $differentImages = [];
            $categories = Category::allWhere('type','complement');
            $id = $_GET['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);
            
            if(!$id){
                header('Location: /dashboard/complements');
            }

            $complement = Complement::find($id);

            if(!$complement || !$complement instanceof Complement){
                header('Location: /dashboard/complements');
            } else{
                if(str_contains($complement->image, ",")){
                    $flag = true; // true if multiple images, false if only one
                    $differentImages = explode(",", $complement->image);
                    foreach($differentImages as $differentImage){
                        if(!str_contains($differentImage, "_")){
                            $complement->currentImage = $differentImage;
                        }
                    } // Para usar en el swiper
                } else{
                    $complement->currentImage = $complement->image;
                }

                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $imageFolder = '../public/build/img/complements/';
                    $savePicture = false;
                    $imagesToSave = [];
                    $imageName = md5(uniqid(rand(),true));

                    if (!empty($_FILES['complement_image']['tmp_name'][0])) {
                        $manager = new ImageManager(new Driver());
                        $tmpNameFiles = $_FILES['complement_image']['tmp_name'];
                        $nameFiles = $_FILES['complement_image']['name'];
                        $imagesToSave = [];
                        $imageNames = [];
                    
                        foreach ($tmpNameFiles as $key => $tmpNameFile) {
                            $tmpNameFile = trim($tmpNameFile);
                    
                            if (empty($tmpNameFile)) {
                                continue;
                            }
                    
                            $image = $manager->read($tmpNameFile)->resize(800, 600);
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
                                'png' => $pngImage,
                                'webp' => $webpImage
                            ];
                    
                            $imageNames[] = $newImageName;
                        }
                    
                        $_POST['image'] = implode(',', $imageNames);
                        $savePicture = true;
                    } else {
                        $_POST['image'] = $complement->image;
                    }

                    $_POST['complement_networks'] = json_encode($_POST['complement_networks'], JSON_UNESCAPED_SLASHES);
                    $_POST['complement_price'] = ceil(($_POST['complement_cost']*1.2)/10)*10;
                    $_POST['category'] = $_POST['category_id'];
                    $complement->sincronize($_POST);
                    $alerts = $complement->validate();

                    if(empty($alerts)){
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
                            } else{
                                $oldPngPath  = $imageFolder . $complement->currentImage . '.png';
                                $oldWebpPath = $imageFolder . $complement->currentImage . '.webp';

                                if (file_exists($oldPngPath)) {
                                    unlink($oldPngPath);
                                }
                                if (file_exists($oldWebpPath)) {
                                    unlink($oldWebpPath);
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
        
                        $result = $complement->saveElement();
                        if($result){
                            header('Location: /dashboard/complements');
                        }
                    }
                }

                $router->render('admin/complements/edit',[
                    'title' => 'Editar extra ofrecido',
                    'alerts' => $alerts,
                    'complement' => $complement??null,
                    'categories' => $categories,
                    'networks' => json_decode($complement->complement_networks),
                    'flag' => $flag,
                    'differentImages' => $differentImages,
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
            $complement = Complement::find($id);
            if(!isset($complement) || !$complement instanceof Complement){
                header('Location: /dashboard/complements');
            }
            
            $result = $complement->deleteElement();
            if($result){
                header('Location: /dashboard/complements');
            }
        }
    }
}