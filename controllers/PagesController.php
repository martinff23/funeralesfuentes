<?php

namespace Controllers;

use Model\Category;
use Model\Cemetery;
use Model\Chapel;
use Model\Crematory;
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

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/index',[
                    'title' => 'Inicio',
                    'user' => $user
                ]);
            } else{
                $router->render('pages/index',[
                    'title' => 'Inicio'
                ]);
            }
        } else{
            $router->render('pages/index',[
                'title' => 'Inicio'
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
                    'user' => $user
                ]);
            } else{
                $router->render('pages/about',[
                    'title' => 'Sobre Funerales Fuentes'
                ]);
            }
        } else{
            $router->render('pages/about',[
                'title' => 'Sobre Funerales Fuentes'
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
                $router->render('pages/packages',[
                    'title' => 'Paquetes de servicios funerarios',
                    'packages' => $packages
                ]);
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
                    'title' => 'Nuestros productos',
                    'products' => $formatedProducts,
                    'user' => $user
                ]);
            } else{
                $router->render('pages/products',[
                    'title' => 'Nuestros productos',
                    'products' => $formatedProducts
                ]);
            }
        } else{
            $router->render('pages/products',[
                'title' => 'Nuestros productos',
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
                    'title' => 'Nuestros servicios',
                    'services' => $groupedServices,
                    'user' => $user
                ]);
            } else{
                $router->render('pages/services',[
                    'title' => 'Nuestros servicios',
                    'services' => $groupedServices
                ]);
            }
        } else{
            $router->render('pages/services',[
                'title' => 'Nuestros servicios',
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
                    'user' => $user
                ]);
            } else{
                $router->render('pages/chapels',[
                    'title' => 'Capillas de velación',
                    'chapels' => $groupedChapels
                ]);
            }
        } else{
            $router->render('pages/chapels',[
                'title' => 'Capillas de velación',
                'chapels' => $groupedChapels
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
                    'user' => $user
                ]);
            } else{
                $router->render('pages/hearses',[
                    'title' => 'Carrozas',
                    'hearses' => $groupedHearses
                ]);
            }
        } else{
            $router->render('pages/hearses',[
                'title' => 'Carrozas',
                'hearses' => $groupedHearses
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
                    'user' => $user
                ]);
            } else{
                $router->render('pages/cemeteries',[
                    'title' => 'Cementerios',
                    'cemeteries' => $groupedCemeteries
                ]);
            }
        } else{
            $router->render('pages/cemeteries',[
                'title' => 'Cementerios',
                'cemeteries' => $groupedCemeteries
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
                    'user' => $user
                ]);
            } else{
                $router->render('pages/crematories',[
                    'title' => 'Crematorios',
                    'crematories' => $groupedCrematories
                ]);
            }
        } else{
            $router->render('pages/crematories',[
                'title' => 'Crematorios',
                'crematories' => $groupedCrematories
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
                $router->render('pages/cotization',[
                    'title' => 'Nuestros servicios'
                ]);
            }
        } else{
            $router->render('pages/cotization',[
                'title' => 'Nuestros servicios'
            ]);
        }
    }

}