<?php

namespace Controllers;

use DateTime;
use Model\Branch;
use Model\Category;
use Model\Cemetery;
use Model\Chapel;
use Model\Crematory;
use Model\Hearse;
use Model\Jobs;
use Model\JobsArchive;
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

        $totalBranches = Branch::countRecords() * 1;
        $totalEmployees = User::countRecords('isEmployee', '1');
        
        $ownSubtypes = Category::allWhere('subtype','own');
        if($ownSubtypes || count($ownSubtypes) > 0){
            foreach($ownSubtypes as $ownSubtype){
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

        $totalJobs = Jobs::countRecords('job_status', 'COMPLETED') * 1;
        $totalJobs = $totalJobs + JobsArchive::countRecords() * 1;

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/index',[
                    'title' => 'Inicio',
                    'totalBranches' => $totalBranches,
                    'totalEmployees' => $totalEmployees,
                    'yearsOfExperience' => $yearsOfExperience,
                    'totalJobs' => $totalJobs,
                    'user' => $user
                ]);
            } else{
                // Page 404
            }
        } else{
            $router->render('pages/index',[
                'title' => 'Inicio',
                'totalBranches' => $totalBranches,
                'totalEmployees' => $totalEmployees,
                'yearsOfExperience' => $yearsOfExperience,
                'totalJobs' => $totalJobs
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
                // Page 404
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
                // Page 404
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

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/products',[
                    'title' => 'Productos funerarios',
                    'products' => $formatedProducts,
                    'user' => $user
                ]);
            } else{
                // Page 404
            }
        } else{
            $router->render('pages/products',[
                'title' => 'Productos funerarios',
                'products' => $formatedProducts
            ]);
        }
    }

    public static function services(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedServices = groupServicesByCategory(Service::all(), groupCategories(Category::allWhere('type','service')));

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/services',[
                    'title' => 'Servicios funerarios',
                    'services' => $groupedServices,
                    'user' => $user
                ]);
            } else{
                // Page 404
            }
        } else{
            $router->render('pages/services',[
                'title' => 'Servicios funerarios',
                'services' => $groupedServices
            ]);
        }
    }

    public static function chapels(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedChapels = groupChapelsByCategory(Chapel::all(), groupCategories(Category::allWhere('type','chapel')));

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/chapels',[
                    'title' => 'Capillas de velación',
                    'chapels' => $groupedChapels,
                    'start' => false,
                    'user' => $user
                ]);
            } else{
                // Page 404
            }
        } else{
            $router->render('pages/chapels',[
                'title' => 'Capillas de velación',
                'chapels' => $groupedChapels,
                'start' => false
            ]);
        }
    }

    public static function hearses(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedHearses = groupHearsesByCategory(Hearse::all(), groupCategories(Category::allWhere('type','hearse')));

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/hearses',[
                    'title' => 'Carrozas',
                    'hearses' => $groupedHearses,
                    'start' => false,
                    'user' => $user
                ]);
            } else{
                // Page 404
            }
        } else{
            $router->render('pages/hearses',[
                'title' => 'Carrozas',
                'hearses' => $groupedHearses,
                'start' => false
            ]);
        }
    }

    public static function cemeteries(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedCemeteries = groupCemeteriesByCategory(Cemetery::all(), groupCategories(Category::allWhere('type','cemetery')));

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/cemeteries',[
                    'title' => 'Cementerios',
                    'cemeteries' => $groupedCemeteries,
                    'start' => false,
                    'user' => $user
                ]);
            } else{
                // Page 404
            }
        } else{
            $router->render('pages/cemeteries',[
                'title' => 'Cementerios',
                'cemeteries' => $groupedCemeteries,
                'start' => false
            ]);
        }
    }

    public static function crematories(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $groupedCrematories = groupCrematoriesByCategory(Crematory::all(), groupCategories(Category::allWhere('type','crematory')));

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/crematories',[
                    'title' => 'Crematorios',
                    'crematories' => $groupedCrematories,
                    'start' => false,
                    'user' => $user
                ]);
            } else{
                // Page 404
            }
        } else{
            $router->render('pages/crematories',[
                'title' => 'Crematorios',
                'crematories' => $groupedCrematories,
                'start' => false
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
                // Page 404
            }
        } else{
            $router->render('pages/cotization',[
                'title' => 'Nuestros servicios'
            ]);
        }
    }

}