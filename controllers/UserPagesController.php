<?php

namespace Controllers;

use Model\Photograph;
use Model\User;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Email;
use Model\Funerals;
use Model\Info;
use Model\Password;
use Model\Subscription;

class UserPagesController {

    public static function index(Router $router){
        session_start();

        // if(isAuth() && isAdmin()){
        //     header('Location: /dashboard/start');
        // }

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/user/menu',[
                    'title' => 'Menú de usuario',
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }

    public static function info(Router $router){
        session_start();

        // if(isAuth() && isAdmin()){
        //     header('Location: /dashboard/start');
        // }

        $alerts = [];
        $user = new User;
        $info = new Info;

        if(!empty($_SESSION)){
            $user = $user->find($_SESSION['id']);

            if($user){
                $info = $info->find($_SESSION['id']);
                if('POST'===$_SERVER['REQUEST_METHOD']){
                    $_POST['id'] = $_SESSION['id'];
                    $info->sincronize($_POST);
                    
                    /** @var \Model\Info $info */
                    $alerts = $info->validateInfo();

                    if(empty($alerts)){
                        $result = $info->saveElement();
                        if($result){
                            header('Location: /user/menu');
                            exit();
                        }
                    }
                }

                $router->render('pages/user/info',[
                    'title' => 'Actualiza información de usuario',
                    'user' => $user,
                    'info' => $info,
                    'alerts' => $alerts
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }

    public static function email(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $alerts = [];
        $user = new User;
        $email = new Email;

        if(!empty($_SESSION)){
            $user = $user->find($_SESSION['id']);

            if($user){

                if('POST'===$_SERVER['REQUEST_METHOD']){
                    if($_SESSION['email'] === $_POST['current_email']){
                        $_POST['id'] = $_SESSION['id'];
                        $email->sincronize($_POST);
                        $alerts = $email->validateEmail();

                        if(empty($alerts)){
                            $result = $email->saveElement();
                            if($result){
                                $_SESSION = [];
                                session_destroy();
                                header('Location: /');
                                exit();
                            }
                        }
                    } else{
                        $email->setAlert('error', 'El correo electrónico actual es incorrecto');
                        $alerts = $email->getAlerts();
                    }
                }

                $router->render('pages/user/email',[
                    'title' => 'Cambiar correo electrónico',
                    'user' => $user,
                    'alerts' => $alerts
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }

    public static function password(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        $alerts = [];
        $password = new Password;
        $user = new User;

        if(!empty($_SESSION)){
            /** @var \Model\User $user */
            $user = $user->find($_SESSION['id']);

            if($user){

                if('POST'===$_SERVER['REQUEST_METHOD']){
                    if(password_verify($_POST['current_password'], $user->password)){
                        $_POST['id'] = $_SESSION['id'];
                        $password->sincronize($_POST);
                        $alerts = $password->validatePassword();

                        if(empty($alerts)){
                            $password->hashPassword();
                            unset($user->password2);
                            $result = $password->saveElement();
                            if($result){
                                $_SESSION = [];
                                session_destroy();
                                header('Location: /');
                                exit();
                            }
                        }
                    } else{
                        $password->setAlert('error', 'La contraseña actual es incorrecta');
                        $alerts = $password->getAlerts();
                    }
                }

                $router->render('pages/user/password',[
                    'title' => 'Cambiar contraseña',
                    'user' => $user,
                    'alerts' => $alerts
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }

    public static function photo(Router $router){
        session_start();

        // if(isAuth() && isAdmin()){
        //     header('Location: /dashboard/start');
        // }

        $alerts=[];
        $user = new User;
        $photograph = new Photograph;

        if(!empty($_SESSION)){
            /** @var \Model\User $user */
            $user = $user->find($_SESSION['id']);

            if($user){
                $photograph = $photograph->find($user->id);
                if(!$photograph){
                    header('Location: /404');
                } else{
                    $user->currentImage = $user->image;
                    
                    if('POST'===$_SERVER['REQUEST_METHOD']){
                        $imageFolder = 'public/build/img/users/';
                        $savePicture = false;
                        $imagesToSave = [];
                        $imageName = md5(uniqid(rand(),true));
    
                        // Read image
                        if (!empty($_FILES['user_image']['tmp_name'])) {
                            $manager = new ImageManager(new Driver());
                            $tmpNameFiles = $_FILES['user_image']['tmp_name'];
                            $imagesToSave = [];
                        
                            $tmpNameFile = trim($tmpNameFiles);
                    
                            $image = $manager->read($tmpNameFile)->resize(800, 600);
                            $pngImage = $image->encode(new PngEncoder(80));
                            $webpImage = $image->encode(new WebpEncoder(80));
                    
                            // Guardar en array temporal
                            $imagesToSave[] = [
                                'name' => $imageName,
                                'png' => $pngImage,
                                'webp' => $webpImage
                            ];
                        
                            $_POST['image'] = $imageName;
                            $savePicture = true;
                        } else {
                            $_POST['image'] = $user->image;
                        }

                        $_POST['id'] = $_SESSION['id'];

                        $photograph->sincronize($_POST);
                        $alerts = $photograph->validate();

                        if(empty($alerts)){
                            if($savePicture){
                                // Create folder if does not exist
                                if(!is_dir(trim($imageFolder))){
                                    mkdir(trim($imageFolder),0777,true);
                                }
            
                                // Make the foldar ALWAYS writable
                                chmod($imageFolder, 0777);
    
                                // Delete previous images before saving the new ones
                                $oldPngPath  = $imageFolder . $user->currentImage . '.png';
                                $oldWebpPath = $imageFolder . $user->currentImage . '.webp';
    
                                if (file_exists($oldPngPath)) {
                                    unlink($oldPngPath);
                                }
                                if (file_exists($oldWebpPath)) {
                                    unlink($oldWebpPath);
                                }
            
                                // Put image on server
                                foreach($imagesToSave as $imageToSave){
                                    $currentPngImage = $imageToSave['png'];
                                    $currentWebpImage = $imageToSave['webp'];
                                    $currentPngImage->save(trim($imageFolder.$imageToSave['name']).'.png');
                                    $currentWebpImage->save(trim($imageFolder.$imageToSave['name']).'.webp');
                                }
                            }
            
                            $result = $photograph->saveElement();
                            if($result){
                                header('Location: /user/menu');
                            }
                        }
                    }

                    $router->render('pages/user/photo',[
                        'title' => 'Actualiza fotografía de usuario',
                        'user' => $user,
                        'alerts' => $alerts
                    ]);
                }
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }

    public static function subscriptions(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }
        
        $alerts = [];
        $user = new User;
        $subscription = new Subscription;

        if(!empty($_SESSION)){
            $user = $user->find($_SESSION['id']);
            
            if($user){
                $subscription = $subscription->find($_SESSION['id']);
                if('POST'===$_SERVER['REQUEST_METHOD']){
                    $_POST['id'] = $_SESSION['id'];
                    $subscription->sincronize($_POST);
                    $alerts = $subscription->validate();
                    if(empty($alerts)){
                        $result = $subscription->saveElement();
                        if($result){
                            header('Location: /user/menu');
                            exit();
                        }
                    }
                }

                $router->render('pages/user/subscriptions',[
                    'title' => 'Administra suscripción de usuario',
                    'user' => $user,
                    'subscription' => $subscription,
                    'alerts' => $alerts
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }

    public static function plans(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/user/plans',[
                    'title' => 'Planes de servicios funerarios del usuario',
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }

    public static function digitickets(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $router->render('pages/user/digitickets',[
                    'title' => 'Boletos digitales de cotizaciones del usuario',
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }

    public static function history(Router $router){
        session_start();

        if(isAuth() && isAdmin()){
            header('Location: /dashboard/start');
        }

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);

            if($user){
                $funerals = Funerals::allWhereOrderBy('funeral_contractor_id', $user->id, 'funeral_date', 'DESC');

                $router->render('pages/user/history',[
                    'title' => 'Boletos digitales de cotizaciones del usuario',
                    'user' => $user,
                    'funerals' => $funerals
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            header('Location: /404');
        }
    }
}