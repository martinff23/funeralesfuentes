<?php

namespace Controllers;

use Classes\Pagination;
use Model\Product;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Category;

class ProductsController {
    
    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        $currentPage = $_GET['page'];
        $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

        if(!$currentPage || $currentPage < 1){
            header('Location: /dashboard/products?page=1');
        }

        $totalRecords = Product::countRecords();
        $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
        
        $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

        if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
            header('Location: /dashboard/products?page=1');
        }

        $products=Product::paginate($recordsPerPage,$pagination->calculateOffset());
        
        $router->render('admin/products/index',[
            'title'=>'Productos ofrecidos',
            'products'=>$products,
            'pagination'=>$pagination->pagination()
        ]);
    }

    public static function create(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        $alerts = [];
        $categories = Category::allWhere('type','product');
        $product = new Product;

        if('POST'===$_SERVER['REQUEST_METHOD']){
            $imageFolder = '../public/build/img/products/';
            $savePicture = false;
            $imagesToSave = [];
            $imageName = md5(uniqid(rand(),true));

            // Read image
            // if(!empty(trim($_FILES['product_image']['tmp_name']))){
            //     $manager = new ImageManager(new Driver());
            //     $pngImage=$manager->read(trim($_FILES['product_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
            //     $webpImage=$manager->read(trim($_FILES['product_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
            //     $_POST['image']=$imageName;
            //     $savePicture=true;
            // }

            if (!empty($_FILES['product_image']['tmp_name'][0])) {
                $manager = new ImageManager(new Driver());
                $tmpNameFiles = $_FILES['product_image']['tmp_name'];
                $nameFiles = $_FILES['product_image']['name'];
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
            
            $_POST['product_networks']=json_encode($_POST['product_networks'], JSON_UNESCAPED_SLASHES);
            $_POST['product_price']=ceil(($_POST['product_cost']*1.2)/10)*10;
            $_POST['category_id']=$_POST['category_id'];
            $product->sincronize($_POST);
            $alerts = $product->validate();

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

                $result = $product->saveElement();
                if($result){
                    header('Location: /dashboard/products');
                }
            }
        }

        $router->render('admin/products/create',[
            'title'=>'Registrar producto ofrecido',
            'alerts'=>$alerts,
            'product'=>$product,
            'categories'=>$categories,
            'networks'=>json_decode($product->product_networks)
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
        $categories = Category::allWhere('type','product');
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        
        if(!$id){
            header('Location: /dashboard/products');
        }

        $product = Product::find($id);

        if(!$product||!$product instanceof Product){
            header('Location: /dashboard/products');
        } else{
            if(str_contains($product->image, ",")){
                $flag = true; // true if multiple images, false if only one
                $differentImages = explode(",", $product->image);
                foreach($differentImages as $differentImage){
                    if(!str_contains($differentImage, "_")){
                        $product->currentImage=$differentImage;
                    }
                } // Para usar en el swiper
            } else{
                $product->currentImage=$product->image;
            }

            if('POST'===$_SERVER['REQUEST_METHOD']){
                $imageFolder = '../public/build/img/products/';
                $savePicture = false;
                $imagesToSave = [];
                $imageName = md5(uniqid(rand(),true));

                // Read image
                if (!empty($_FILES['product_image']['tmp_name'][0])) {
                    $manager = new ImageManager(new Driver());
                    $tmpNameFiles = $_FILES['product_image']['tmp_name'];
                    $nameFiles = $_FILES['product_image']['name'];
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
                    $_POST['image'] = $product->image;
                }
                

                // Read image
                // if(!empty(trim($_FILES['product_image']['tmp_name']))){
                //     $manager = new ImageManager(new Driver());
                //     $pngImage=$manager->read(trim($_FILES['product_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                //     $webpImage=$manager->read(trim($_FILES['product_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                //     $_POST['image']=$imageName;
                //     $savePicture=true;
                // } else{
                //     $_POST['image']=$product->currentImage;
                // }

                $_POST['product_networks'] = json_encode($_POST['product_networks'], JSON_UNESCAPED_SLASHES);
                $_POST['product_price'] = ceil(($_POST['product_cost']*1.2)/10)*10;
                $_POST['category_id'] = $_POST['category_id'];
                $product->sincronize($_POST);
                $alerts = $product->validate();

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
    
                    $result=$product->saveElement();
                    if($result){
                        header('Location: /dashboard/products');
                    }
                }
            }

            $router->render('admin/products/edit',[
                'title' => 'Editar producto ofrecido',
                'alerts' => $alerts,
                'product' => $product??null,
                'categories' => $categories,
                'networks' => json_decode($product->product_networks),
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
        
        if('POST' === $_SERVER['REQUEST_METHOD']){
            $id = $_POST['id'];
            $product = Product::find($id);
            if(!isset($product) || !$product instanceof Product){
                header('Location: /dashboard/products');
            }
            
            $result = $product->deleteElement();
            if($result){
                header('Location: /dashboard/products');
            }
        }
    }
}