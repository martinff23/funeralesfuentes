<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;


class AuthController {
    public static function login(Router $router) {

        $alerts = [];
        if('POST'===$_SERVER['REQUEST_METHOD']) {
            $auth = new User($_POST);
            $alerts = $auth->validateLogin();
            
            if(empty($alerts)) {
                // Verificar que el usuario exista
                $us = User::where('email', $auth->email);
                if(!$us instanceof User){
                    User::setAlert('error', 'El usuario no existe');
                } else {
                    if(!$us->confirmed){
                        User::setAlert('error', 'El usuario no esta confirmado');
                    } else if("INACTIVE" === strtoupper($us->status)){
                        User::setAlert('error', 'El usuario no esta habilitado');
                    } else{
                        // El Usuario existe
                        if( password_verify($_POST['password'], $us->password) ){
                            // Iniciar la sesión
                            session_start();    
                            $_SESSION['id'] = $us->id;
                            $_SESSION['name'] = $us->name;
                            $_SESSION['f_name'] = $us->f_name;
                            $_SESSION['email'] = $us->email;
                            $_SESSION['isAdmin'] = $us->isAdmin ?? null;
                            $_SESSION['isEmployee'] = $us->isEmployee ?? null;

                            //Redirection
                            if($us->isAdmin){
                                header('Location: /dashboard/start');
                            } else if($us->isEmployee){
                                header('Location: /dashboard/start');
                            } else{
                                header('Location: /');
                            }
                            
                        } else {
                            User::setAlert('error', 'Contraseña incorrecta o usuario no verificado');
                        }
                    }
                }
            }
        }

        $alerts = User::getAlerts();
        
        $router->render('auth/login', [
            'title' => 'Inicio de sesión',
            'alerts' => $alerts
        ]);
    }

    public static function logout(){
        if('POST'===$_SERVER['REQUEST_METHOD']) {
            session_start();
            $_SESSION = [];
            session_destroy();
            header('Location: /');
            exit();
        }
    }

    public static function register(Router $router){
        $alerts = [];
        $us = new User;

        if('POST'===$_SERVER['REQUEST_METHOD']){
            $captcha = $_POST['g-recaptcha-response'];
            
            if (empty($captcha)) {
                die("Por favor verifica que no eres un robot.");
            }

            $secretKey = $_ENV['CAP_SEC'];
            $ip = $_SERVER['REMOTE_ADDR'];

            $response = file_get_contents(
                "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha&remoteip=$ip"
            );
            $responseKeys = json_decode($response, true);

            if (!$responseKeys["success"]) {
                die("Verificación fallida, intenta de nuevo.");
            }

            $imageFolder='../public/build/img/users/';
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
                $_POST['image'] = $us->image;
            }

            $_POST['status'] = "ACTIVE";
            $_POST['registerOrigin'] = "0";
            $us->sincronize($_POST);
            
            $alerts = $us->validateAccount();

            if(empty($alerts)) {
                
                if($savePicture){
                    // Create folder if does not exist
                    if(!is_dir(trim($imageFolder))){
                        mkdir(trim($imageFolder),0777,true);
                    }

                    // Make the foldar ALWAYS writable
                    chmod($imageFolder, 0777);

                    // Delete previous images before saving the new ones
                    $oldPngPath  = $imageFolder . $us->currentImage . '.png';
                    $oldWebpPath = $imageFolder . $us->currentImage . '.webp';

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

                $userExists = User::where('email', $us->email);

                if($userExists) {
                    User::setAlert('error', 'El Usuario ya esta registrado');
                    $alerts = User::getAlerts();
                } else {
                    // Hashear el password
                    $us->hashPassword();

                    // Eliminar password2
                    unset($us->password2);

                    // Generar el Token
                    $us->createToken();

                    // Crear un nuevo usuario
                    $resultado =  $us->saveElement();

                    // Enviar email
                    $email = new Email($us->email, $us->name, $us->token);
                    $email->sendConfirmation();
                    

                    if($resultado) {
                        header('Location: /message');
                    }
                }
            }
        }

        $router->render('auth/register', [
            'title' => 'Creación de cuenta',
            'us' => $us, 
            'alerts' => $alerts
        ]);
    }

    public static function forgot(Router $router) {
        $alerts = [];
        
        if('POST'===$_SERVER['REQUEST_METHOD']) {
            $auth = new User($_POST);
            $alerts = $auth->validateEmail();

            if(empty($alerts)) {
                // Buscar el usuario
                $us = User::where('email', $auth->email);

                if($us instanceof User && $us->confirmed && "ACTIVE" === strtoupper($us->status)) {

                    // Generar un nuevo token
                    $us->createToken();
                    unset($us->password2);

                    // Actualizar el usuario
                    $us->saveElement();

                    // Enviar el email
                    $email = new Email( $us->email, $us->name, $us->token );
                    $email->sendInstructions();


                    // Imprimir la alerta
                    // Usuario::setAlerta('success', 'Hemos enviado las instrucciones a tu email');

                    $alerts['success'][] = 'Hemos enviado las instrucciones a tu email';
                } else {
                 
                    // Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');

                    $alerts['error'][] = 'El Usuario no existe, está inhabilitado o no esta confirmado';
                }
            }
        }

        $router->render('auth/forgot', [
            'title' => 'Olvidé mi contraseña',
            'alerts' => $alerts
        ]);
    }

    public static function reset(Router $router) {

        $token = s($_GET['token']);
        $validToken = true;
        if(!$token) header('Location: /');

        // Identificar el usuario con este token
        $us = User::where('token', $token);

        if(!$us instanceof User){
            User::setAlert('error', 'Usuario no válido');
            $alerts = User::getAlerts();
            // Muestra la vista
            $router->render('auth/reset', [
                'title' => 'Reestablecer contraseña',
                'alerts' => $alerts,
                'validToken' => $validToken
            ]);
        } else{
            if(empty($us)) {
                User::setAlert('error', 'Usuario no válido');
                $validToken = false;
            } else if("INACTIVE" === strtoupper($us->status)) {
                User::setAlert('error', 'Usuario inhabilitado');
                $validToken = false;
            }
            if('POST'===$_SERVER['REQUEST_METHOD']) {

                // Añadir el nuevo password
                $us->sincronize($_POST);
    
                // Validar el password
                $alerts = $us->validatePasswordRecovery();
    
                if(empty($alerts)) {
                    // Hashear el nuevo password
                    $us->hashPassword();
    
                    // Eliminar el Token
                    $us->token = null;
    
                    // Guardar el usuario en la BD
                    $resultado = $us->saveElement();
    
                    // Redireccionar
                    if($resultado) {
                        header('Location: /login');
                    }
                }
            }
    
            $alerts = User::getAlerts();
            
            $router->render('auth/reset', [
                'title' => 'Reestablecer contraseña',
                'alerts' => $alerts,
                'validToken' => $validToken
            ]);
        }
    }

    public static function message(Router $router) {
        session_start();

        if(!empty($_SESSION)){
            $user = User::find($_SESSION['id']);
            if($user){
                $router->render('auth/message', [
                    'title' => 'Cuenta creada exitosamente',
                    'user' => $user
                ]);
            } else{
                header('Location: /404');
            }
        } else{
            $router->render('auth/message', [
                'title' => 'Cuenta creada exitosamente'
            ]);
        }

    }

    public static function confirmaccount(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $us = User::where('token', $token);

        if(!$us instanceof User){
            User::setAlert('error', 'Token no válido, la cuenta no se confirmó');
        } else{
            if(empty($us)) {
                // No se encontró un usuario con ese token
                User::setAlert('error', 'Token no válido, la cuenta no se confirmó');
            } else if("INACTIVE" === strtoupper($us->status)) {
                // No se encontró un usuario con ese token
                User::setAlert('error', 'Usuario inhabilitado, la cuenta no se confirmó');
            } else {
                // Confirmar la cuenta
                $us->confirmed = 1;
                $us->token = '';
                unset($us->password2);
                
                // Guardar en la BD
                $us->saveElement();
    
                User::setAlert('success', 'Cuenta comprobada correctamente');
            }
        }

        $router->render('auth/confirm', [
            'title' => 'Confirma tu cuenta Funerales Fuentes',
            'alerts' => User::getAlerts()
        ]);
    }
}