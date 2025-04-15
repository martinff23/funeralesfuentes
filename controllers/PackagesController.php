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
use Model\Chapel;
use Model\Complement;
use Model\Crematory;
use Model\Hearse;
use Model\Package;
use Model\Product;
use Model\Service;
use Model\User;

/**
 * Class PackagesController
 *
 * Handles the logic for viewing, creating, editing, and deleting funeral packages.
 */
class PackagesController {

    /**
     * Renders the dashboard view for packages.
     *
     * @param Router $router MVC Router instance
     * @return void
     */
    public static function dashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            
        } else{
            header('Location: /404');
        }

        $currentPage = $_GET['page'];
        $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

        if(!$currentPage || $currentPage < 1){
            header('Location: /dashboard/packages?page=1');
        }

        $totalRecords = Package::countRecords('status', 'ACTIVE');
        $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
        
        $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

        if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
            header('Location: /dashboard/packages?page=1');
        }

        $packages=Package::paginateStatus($recordsPerPage,$pagination->calculateOffset(), 'ACTIVE');

        $router->render('admin/packages/index',[
            'title'=>'Paquetes ofrecidos',
            'packages'=>$packages,
            'pagination'=>$pagination->pagination(),
            'user' => $user
        ]);
    }

    /**
     * Handles creation of a new funeral package.
     * Loads necessary data and processes form submissions.
     *
     * @param Router $router MVC Router instance
     * @return void
     */
    public static function create(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            
        } else{
            header('Location: /404');
        }
        
        $alerts=[];
        $coffins = Product::allWhere('tags','Ata');
        $urns = Product::allWhere('tags','Urn');
        $services = Service::all();
        $complements = Complement::all();
        $chapels = Chapel::all();
        $hearses = Hearse::all();
        $cemeteries = Cemetery::all();
        $crematories = Crematory::all();
        $package = new Package();

        if('POST' === $_SERVER['REQUEST_METHOD']){
            $imageFolder = '../public/build/img/packages/';
            $savePicture = false;

            // Read image
            $imageName = md5(uniqid(rand(),true));
            if(!empty(trim($_FILES['package_image']['tmp_name']))){
                $manager = new ImageManager(new Driver());
                $pngImage = $manager->read(trim($_FILES['package_image']['tmp_name']))->resize(800,600)->encode(new PngEncoder(80));
                $webpImage = $manager->read(trim($_FILES['package_image']['tmp_name']))->resize(800,600)->encode(new WebpEncoder(80));
                $_POST['image'] = $imageName;
                $savePicture = true;
            }
            
            // $_POST['products'] = $_POST['products_tags'];
            // $_POST['products_ids'] = $_POST['products_tags_ids'];
            $_POST['coffin'] = $_POST['coffin_search'];
            $_POST['coffin_id'] = $_POST['coffin_id'];
            $_POST['urn'] = $_POST['urn_search'];
            $_POST['urn_id'] = $_POST['urn_id'];
            $_POST['services'] = $_POST['services_tags'];
            $_POST['services_ids'] = $_POST['services_tags_ids'];
            $_POST['complements'] = $_POST['complements_tags'];
            $_POST['complements_ids'] = $_POST['complements_tags_ids'];
            $_POST['chapel'] = $_POST['chapels_tags'];
            $_POST['chapel_id'] = $_POST['chapels_tags_ids'];
            $_POST['hearse'] = $_POST['hearses_tags'];
            $_POST['hearse_id'] = $_POST['hearses_tags_ids'];
            $_POST['cemetery'] = $_POST['cemeteries_tags'];
            $_POST['cemetery_id'] = $_POST['cemeteries_tags_ids'];
            $_POST['crematory'] = $_POST['crematories_tags'];
            $_POST['crematory_id'] = $_POST['crematories_tags_ids'];

            $productsCost = 0.0;
            $productsPrice = 0.0;
            $servicesCost = 0.0;
            $servicesPrice = 0.0;
            $complementsCost = 0.0;
            $complementsPrice = 0.0;
            $chapelsCost = 0.0;
            $chapelsPrice = 0.0;
            $hearsesCost = 0.0;
            $hearsesPrice = 0.0;
            $cemeteriesCost = 0.0;
            $cemeteriesPrice = 0.0;
            $crematoriesCost = 0.0;
            $crematoriesPrice = 0.0;

            $indexCoff = array_search($_POST['coffin_id'], array_column($coffins, "id"));

            /** @var \Model\Product $cf */
            $cf = $coffins[$indexCoff];
            $cfCost = floatval($cf->product_cost);
            $cfPrice = floatval($cf->product_price);
            $productsCost += $cfCost;
            $productsPrice += $cfPrice;

            $indexUrn = array_search($_POST['urn_id'], array_column($urns, "id"));
            
            /** @var \Model\Product $ur */
            $ur = $urns[$indexUrn];
            $urCost = floatval($ur->product_cost);
            $urPrice = floatval($ur->product_price);
            $productsCost += $urCost;
            $productsPrice += $urPrice;

            $servicesList=explode(",",$_POST['services_ids']);
            foreach($servicesList as $serviceItem){
                $index = array_search($serviceItem, array_column($services, "id"));
                
            
                /** @var \Model\Service $sv */
                $sv = $services[$index];
                $svCost = floatval($sv->service_cost);
                $svPrice = floatval($sv->service_price);
                $servicesCost += $svCost;
                $servicesPrice += $svPrice;
            }

            $complementsList=explode(",",$_POST['complements_ids']);
            foreach($complementsList as $complementItem){
                $index = array_search($complementItem, array_column($complements, "id"));
                
            
                /** @var \Model\Complement $cm */
                $cm = $complements[$index];
                $cmCost = floatval($cm->complement_cost);
                $cmPrice = floatval($cm->complement_price);
                $complementsCost += $cmCost;
                $complementsPrice += $cmPrice;
            }

            $chapelsList=explode(",",$_POST['chapel_id']);
            foreach($chapelsList as $chapelItem){
                $index = array_search($chapelItem, array_column($chapels, "id"));
                
                /** @var \Model\Chapel $ch */
                $ch = $chapels[$index];
                $chCost = floatval($ch->chapel_cost);
                $chPrice = floatval($ch->chapel_price);
                $chapelsCost += $chCost;
                $chapelsPrice += $chPrice;
            }

            $hearsesList=explode(",",$_POST['hearse_id']);
            foreach($hearsesList as $hearseItem){
                $index = array_search($hearseItem, array_column($hearses, "id"));
                
                /** @var \Model\Hearse $hs */
                $hs = $hearses[$index];
                $hsCost = floatval($hs->hearse_cost);
                $hsPrice = floatval($hs->hearse_price);
                $hearsesCost += $hsCost;
                $hearsesPrice += $hsPrice;
            }

            $cemeteriesList=explode(",",$_POST['cemetery_id']);
            foreach($cemeteriesList as $cemeteryItem){
                $index = array_search($cemeteryItem, array_column($cemeteries, "id"));
                
                /** @var \Model\Cemetery $cm */
                $cm = $cemeteries[$index];
                $cmCost = floatval($cm->cemetery_cost);
                $cmPrice = floatval($cm->cemetery_price);
                $cemeteriesCost = 0.0;
                $cemeteriesPrice = 0.0;
            }

            $crematoriesList=explode(",",$_POST['crematory_id']);
            foreach($crematoriesList as $crematoryItem){
                $index = array_search($crematoryItem, array_column($crematories, "id"));
                
                /** @var \Model\Crematory $cm */
                $cm = $crematories[$index];
                $cmCost = floatval($cm->crematory_cost);
                $cmPrice = floatval($cm->crematory_price);
                $crematoriesCost = 0.0;
                $crematoriesPrice = 0.0;
            }

            $totalCost = $productsCost + $servicesCost + $complementsCost + $chapelsCost + $hearsesCost + $cemeteriesCost + $crematoriesCost;
            $totalPrice = $productsPrice + $servicesPrice + $complementsPrice + $chapelsPrice + $hearsesPrice + $cemeteriesPrice + $crematoriesPrice;
            
            $_POST['package_cost']=$totalCost;
            $_POST['package_price']=$totalPrice;

            $package->sincronize($_POST);
            $alerts = $package->validate();

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

                $result=$package->saveElement();
                if($result){
                    header('Location: /dashboard/packages');
                }
            }
        }

        $router->render('admin/packages/create',[
            'title'=>'Registrar paquete',
            'alerts'=>$alerts,
            'package'=>$package,
            'coffins'=>$coffins,
            'urns'=>$urns,
            'services'=>$services,
            'complements'=>$complements,
            'chapels'=>$chapels,
            'hearses'=>$hearses,
            'cemeteries'=>$cemeteries,
            'crematories'=>$crematories,
            'user' => $user
        ]);
    }

    /**
     * Handles editing of an existing funeral package.
     * Loads existing package data and updates it if needed.
     *
     * @param Router $router MVC Router instance
     * @return void
     */
    public static function edit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            
        } else{
            header('Location: /404');
        }
        
        $alerts=[];
        $categories=Category::allWhere('name','package_');
        $id=$_GET['id'];
        $id=filter_var($id,FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /dashboard/packages');
        }

        $coffins = Product::allWhere('tags','Ata');
        $urns = Product::allWhere('tags','Urn');
        $services = Service::all();
        $complements = Complement::all();
        $chapels = Chapel::all();
        $hearses = Hearse::all();
        $cemeteries = Cemetery::all();
        $crematories = Crematory::all();
        $package = Package::find($id);

        if(!$package||!$package instanceof Package){
            header('Location: /dashboard/packages');
        } else{
            $package->currentImage=$package->image;

            if('POST'===$_SERVER['REQUEST_METHOD']){
                $imageFolder='../public/build/img/packages/';
                $savePicture=false;

                // Read image
                $imageName=md5(uniqid(rand(),true));
                if(!empty(trim($_FILES['package_image']['tmp_name']))){
                    $manager = new ImageManager(new Driver());
                    $pngImage=$manager->read(trim($_FILES['package_image']['tmp_name']))->resize(800,600)->encode(new PngEncoder(80));
                    $webpImage=$manager->read(trim($_FILES['package_image']['tmp_name']))->resize(800,600)->encode(new WebpEncoder(80));
                    $_POST['image']=$imageName;
                    $savePicture=true;
                } else{
                    $_POST['image']=$package->currentImage;
                }

                // $_POST['products']=$_POST['products_tags'];
                // $_POST['products_ids']=$_POST['products_tags_ids'];
                $_POST['coffin']=$_POST['coffin_search'];
                $_POST['coffin_id']=$_POST['coffin_id'];
                $_POST['urn']=$_POST['urn_search'];
                $_POST['urn_id']=$_POST['urn_id'];
                $_POST['services']=$_POST['services_tags'];
                $_POST['services_ids']=$_POST['services_tags_ids'];
                $_POST['complements']=$_POST['complements_tags'];
                $_POST['complements_ids']=$_POST['complements_tags_ids'];
                $_POST['chapel']=$_POST['chapels_tags'];
                $_POST['chapel_id']=$_POST['chapels_tags_ids'];
                $_POST['hearse']=$_POST['hearses_tags'];
                $_POST['hearse_id']=$_POST['hearses_tags_ids'];
                $_POST['cemetery']=$_POST['cemeteries_tags'];
                $_POST['cemetery_id']=$_POST['cemeteries_tags_ids'];
                $_POST['crematory']=$_POST['crematories_tags'];
                $_POST['crematory_id']=$_POST['crematories_tags_ids'];

                $productsCost = 0.0;
                $productsPrice = 0.0;
                $servicesCost = 0.0;
                $servicesPrice = 0.0;
                $complementsCost = 0.0;
                $complementsPrice = 0.0;
                $chapelsCost = 0.0;
                $chapelsPrice = 0.0;
                $hearsesCost = 0.0;
                $hearsesPrice = 0.0;
                $cemeteriesCost = 0.0;
                $cemeteriesPrice = 0.0;
                $crematoriesCost = 0.0;
                $crematoriesPrice = 0.0;

                $indexCoff = array_search($_POST['coffin_id'], array_column($coffins, "id"));
                
                /** @var \Model\Product $cf */
                $cf = $coffins[$indexCoff];
                $cfCost = floatval($cf->product_cost);
                $cfPrice = floatval($cf->product_price);
                $productsCost += $cfCost;
                $productsPrice += $cfPrice;

                $indexUrn = array_search($_POST['urn_id'], array_column($urns, "id"));
                
                /** @var \Model\Product $ur */
                $ur = $urns[$indexUrn];
                $urCost = floatval($ur->product_cost);
                $urPrice = floatval($ur->product_price);
                $productsCost += $urCost;
                $productsPrice += $urPrice;

                $servicesList=explode(",",$_POST['services_ids']);
                foreach($servicesList as $serviceItem){
                    $index = array_search($serviceItem, array_column($services, "id"));
                    
                    /** @var \Model\Service $sv */
                    $sv = $services[$index];
                    $svCost = floatval($sv->service_cost);
                    $svPrice = floatval($sv->service_price);
                    $servicesCost += $svCost;
                    $servicesPrice += $svPrice;
                }

                $complementsList=explode(",",$_POST['complements_ids']);
                foreach($complementsList as $complementItem){
                    $index = array_search($complementItem, array_column($complements, "id"));
                    
                    /** @var \Model\Complement $cm */
                    $cm = $complements[$index];
                    $cmCost = floatval($cm->complement_cost);
                    $cmPrice = floatval($cm->complement_price);
                    $complementsCost += $cmCost;
                    $complementsPrice += $cmPrice;
                }

                $chapelsList=explode(",",$_POST['chapel_id']);
                foreach($chapelsList as $chapelItem){
                    $index = array_search($chapelItem, array_column($chapels, "id"));
                    
                    /** @var \Model\Chapel $ch */
                    $ch = $chapels[$index];
                    $chCost = floatval($ch->chapel_cost);
                    $chPrice = floatval($ch->chapel_price);
                    $chapelsCost += $chCost;
                    $chapelsPrice += $chPrice;
                }

                $hearsesList=explode(",",$_POST['hearse_id']);
                foreach($hearsesList as $hearseItem){
                    $index = array_search($hearseItem, array_column($hearses, "id"));
                    
                    /** @var \Model\Hearse $hs */
                    $hs = $hearses[$index];
                    $hsCost = floatval($hs->hearse_cost);
                    $hsPrice = floatval($hs->hearse_price);
                    $hearsesCost += $hsCost;
                    $hearsesPrice += $hsPrice;
                }

                $cemeteriesList=explode(",",$_POST['cemetery_id']);
                foreach($cemeteriesList as $cemeteryItem){
                    $index = array_search($cemeteryItem, array_column($cemeteries, "id"));
                    
                    /** @var \Model\Cemetery $cm */
                    $cm = $cemeteries[$index];
                    $cmCost = floatval($cm->cemetery_cost);
                    $cmPrice = floatval($cm->cemetery_price);
                    $cemeteriesCost = 0.0;
                    $cemeteriesPrice = 0.0;
                }
    
                $crematoriesList=explode(",",$_POST['crematory_id']);
                foreach($crematoriesList as $crematoryItem){
                    $index = array_search($crematoryItem, array_column($crematories, "id"));
                    
                    /** @var \Model\Crematory $cm */
                    $cm = $crematories[$index];
                    $cmCost = floatval($cm->crematory_cost);
                    $cmPrice = floatval($cm->crematory_price);
                    $crematoriesCost = 0.0;
                    $crematoriesPrice = 0.0;
                }
    
                $totalCost = $productsCost + $servicesCost + $complementsCost + $chapelsCost + $hearsesCost + $cemeteriesCost + $crematoriesCost;
                $totalPrice = $productsPrice + $servicesPrice + $complementsPrice + $chapelsPrice + $hearsesPrice + $cemeteriesPrice + $crematoriesPrice;
                
                $_POST['package_cost']=$totalCost;
                $_POST['package_price']=$totalPrice;

                $package->sincronize($_POST);
                $alerts=$package->validate();

                if(empty($alerts)){
                    if($savePicture){
                        // Create folder if does not exist
                        if(!is_dir(trim($imageFolder))){
                            mkdir(trim($imageFolder),0777,true);
                        }
    
                        // Make the foldar ALWAYS writable
                        chmod($imageFolder, 0777);

                        $oldPngPath  = $imageFolder . $package->currentImage . '.png';
                        $oldWebpPath = $imageFolder . $package->currentImage . '.webp';

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
    
                    $result=$package->saveElement();
                    if($result){
                        header('Location: /dashboard/packages');
                    }
                }
            }

            $router->render('admin/packages/edit',[
                'title'=>'Editar paquete',
                'alerts'=>$alerts,
                'package'=>$package??null,
                'coffins'=>$coffins,
                'urns'=>$urns,
                'services'=>$services,
                'complements'=>$complements,
                'chapels'=>$chapels,
                'hearses'=>$hearses,
                'categories'=>$categories,
                'cemeteries'=>$cemeteries,
                'crematories'=>$crematories,
                'user' => $user
            ]);
        }
    }

    /**
     * Handles deletion of a funeral package.
     *
     * @param Router $router MVC Router instance
     * @return void
     */
    public static function delete(){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        if('POST'===$_SERVER['REQUEST_METHOD']){
            $id=$_POST['id'];
            $package=Package::find($id);
            if(!isset($package)||!$package instanceof Package){
                header('Location: /dashboard/packages');
            }
            
            $result=$package->deleteNElement();
            if($result){
                header('Location: /dashboard/packages');
            }
        }
    }
}