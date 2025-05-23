<?php

namespace Controllers;

use DateTime;
use Model\Branch;
use Model\Category;
use Model\Cemetery;
use Model\Chapel;
use Model\Contact;
use Model\Crematory;
use Model\Funerals;
use Model\FuneralsArchive;
use Model\Hearse;
use Model\Package;
use Model\Product;
use Model\Service;
use Model\User;
use MVC\Router;


class PagesController {

    public static function index(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $alerts = [];
        $totalBranches = Branch::countRecords() * 1;
        $totalEmployees = User::countRecords('isEmployee', '1');
        
        $ownSubtypes = Category::allWhere('subtype','own');
        if($ownSubtypes || count($ownSubtypes) > 0){
            foreach($ownSubtypes as $ownSubtype){
                
                /** @var \Model\Category $ownSubtype */
                if('chapel'===$ownSubtype->type || 'cemetery'===$ownSubtype->type || 'crematory'===$ownSubtype->type || 'hearse'===$ownSubtype->type){
                    $totalBranches = $totalBranches + Cemetery::countRecords('category_id', $ownSubtype->id) * 1;
                    $totalBranches = $totalBranches + Crematory::countRecords('category_id', $ownSubtype->id) * 1;
                    $totalBranches = $totalBranches + Chapel::countRecords('category_id', $ownSubtype->id) * 1;
                    $totalBranches = $totalBranches + Hearse::countRecords('category_id', $ownSubtype->id) * 1;
                }
            }
        }

        $oldestDate = new DateTime(Branch::selectOldestDate('open_date'));
        $today = new DateTime();
        $yearsOfExperience = ($oldestDate->diff($today))->y;

        $totalFunerals = Funerals::countRecords('funeral_status', 'COMPLETED') * 1;
        $totalFunerals = $totalFunerals + FuneralsArchive::countRecords() * 1;

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/index',[
                    'title' => 'Inicio',
                    'totalBranches' => $totalBranches,
                    'totalEmployees' => $totalEmployees,
                    'yearsOfExperience' => $yearsOfExperience,
                    'totalFunerals' => $totalFunerals,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{

            $router->render('pages/index',[
                'title' => 'Inicio',
                'totalBranches' => $totalBranches,
                'totalEmployees' => $totalEmployees,
                'yearsOfExperience' => $yearsOfExperience,
                'totalFunerals' => $totalFunerals
            ]);
        }
    }

    public static function about(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/about',[
                    'title' => 'Sobre Funerales Fuentes',
                    'start' => false,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/about',[
                'title' => 'Sobre Funerales Fuentes',
                'start' => false
            ]);
        }
    }

    public static function packages(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }
        
        $packages = Package::all();
        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/packages',[
                    'title' => 'Paquetes de servicios funerarios',
                    'packages' => $packages,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/packages',[
                'title' => 'Paquetes de servicios funerarios',
                'packages' => $packages
            ]);
        }
    }

    public static function products(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $formatedProducts = groupProductsByCategory(Product::all(), groupCategories(Category::allWhere('type','product')));
        
        $folder_name = __DIR__ . '/../public/build/img/wip';
        $selectedImage = getRandomImageFromFolder($folder_name, ['png', 'jpg', 'jpeg']);

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/products',[
                    'title' => 'Productos funerarios',
                    'products' => $formatedProducts,
                    'selectedImage' => $selectedImage,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/products',[
                'title' => 'Productos funerarios',
                'products' => $formatedProducts,
                'selectedImage' => $selectedImage,
            ]);
        }
    }

    public static function services(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedServices = groupServicesByCategory(Service::all(), groupCategories(Category::allWhere('type','service')));

        $folder_name = __DIR__ . '/../public/build/img/wip';
        $selectedImage = getRandomImageFromFolder($folder_name, ['png', 'jpg', 'jpeg']);

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/services',[
                    'title' => 'Servicios funerarios',
                    'services' => $groupedServices,
                    'selectedImage' => $selectedImage,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/services',[
                'title' => 'Servicios funerarios',
                'services' => $groupedServices,
                'selectedImage' => $selectedImage
            ]);
        }
    }
    
    public static function branches(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedBranches = groupBranchesByCategory(Branch::all(), groupCategories(Category::allWhere('type','branch')));

        $folder_name = __DIR__ . '/../public/build/img/wip';
        $selectedImage = getRandomImageFromFolder($folder_name, ['png', 'jpg', 'jpeg']);

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/branches',[
                    'title' => 'Sucursales y puntos de venta',
                    'branches' => $groupedBranches,
                    'start' => false,
                    'selectedImage' => $selectedImage,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/branches',[
                'title' => 'Sucursales y puntos de venta',
                'branches' => $groupedBranches,
                'start' => false,
                'selectedImage' => $selectedImage,
            ]);
        }
    }

    public static function chapels(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedChapels = groupChapelsByCategory(Chapel::all(), groupCategories(Category::allWhere('type','chapel')));

        $folder_name = __DIR__ . '/../public/build/img/wip';
        $selectedImage = getRandomImageFromFolder($folder_name, ['png', 'jpg', 'jpeg']);

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/chapels',[
                    'title' => 'Capillas de velación',
                    'chapels' => $groupedChapels,
                    'start' => false,
                    'selectedImage' => $selectedImage,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/chapels',[
                'title' => 'Capillas de velación',
                'chapels' => $groupedChapels,
                'start' => false,
                'selectedImage' => $selectedImage
            ]);
        }
    }

    public static function hearses(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedHearses = groupHearsesByCategory(Hearse::all(), groupCategories(Category::allWhere('type','hearse')));

        $folder_name = __DIR__ . '/../public/build/img/wip';
        $selectedImage = getRandomImageFromFolder($folder_name, ['png', 'jpg', 'jpeg']);

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/hearses',[
                    'title' => 'Carrozas',
                    'hearses' => $groupedHearses,
                    'start' => false,
                    'selectedImage' => $selectedImage,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/hearses',[
                'title' => 'Carrozas',
                'hearses' => $groupedHearses,
                'start' => false,
                'selectedImage' => $selectedImage
            ]);
        }
    }

    public static function cemeteries(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedCemeteries = groupCemeteriesByCategory(Cemetery::all(), groupCategories(Category::allWhere('type','cemetery')));

        $folder_name = __DIR__ . '/../public/build/img/wip';
        $selectedImage = getRandomImageFromFolder($folder_name, ['png', 'jpg', 'jpeg']);

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/cemeteries',[
                    'title' => 'Cementerios',
                    'cemeteries' => $groupedCemeteries,
                    'start' => false,
                    'selectedImage' => $selectedImage,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/cemeteries',[
                'title' => 'Cementerios',
                'cemeteries' => $groupedCemeteries,
                'start' => false,
                'selectedImage' => $selectedImage
            ]);
        }
    }

    public static function crematories(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedCrematories = groupCrematoriesByCategory(Crematory::all(), groupCategories(Category::allWhere('type','crematory')));

        $folder_name = __DIR__ . '/../public/build/img/wip';
        $selectedImage = getRandomImageFromFolder($folder_name, ['png', 'jpg', 'jpeg']);

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/crematories',[
                    'title' => 'Crematorios',
                    'crematories' => $groupedCrematories,
                    'start' => false,
                    'selectedImage' => $selectedImage,
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/crematories',[
                'title' => 'Crematorios',
                'crematories' => $groupedCrematories,
                'start' => false,
                'selectedImage' => $selectedImage
            ]);
        }
    }

    public static function cotization(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/cotization',[
                    'title' => 'Nuestros servicios',
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('pages/cotization',[
                'title' => 'Nuestros servicios'
            ]);
        }
    }

    public static function error(Router $router){
        session_start();

        $folder_name = __DIR__ . '/../public/build/img/error';

        $selectedImage = getRandomImageFromFolder($folder_name, ['png', 'jpg', 'jpeg']);

        $router->render('pages/error',[
            'title' => 'Página no encontrada',
            'selectedImage' => $selectedImage
        ]);
    }
}