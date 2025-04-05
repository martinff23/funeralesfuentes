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
                $user = User::where('email', $auth->email);
                if(!$user instanceof User){
                    User::setAlert('error', 'El usuario no existe');
                } else {
                    if(!$user->confirmed){
                        User::setAlert('error', 'El usuario no esta confirmado');
                    } else if("INACTIVE" === strtoupper($user->status)){
                        User::setAlert('error', 'El usuario no esta habilitado');
                    } else{
                        // El Usuario existe
                        if( password_verify($_POST['password'], $user->password) ){
                            // Iniciar la sesión
                            session_start();    
                            $_SESSION['id'] = $user->id;
                            $_SESSION['name'] = $user->name;
                            $_SESSION['f_name'] = $user->f_name;
                            $_SESSION['email'] = $user->email;
                            $_SESSION['isAdmin'] = $user->isAdmin ?? null;
                            $_SESSION['isEmployee'] = $user->isEmployee ?? null;

                            //Redirection
                            if($user->isAdmin){
                                header('Location: /dashboard/start');
                            } else if($user->isEmployee){
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
        $user = new User;

        if('POST'===$_SERVER['REQUEST_METHOD']){
            $imageFolder='../public/build/img/users/';

            $imageName=md5(uniqid(rand(),true));
            if(!empty(trim($_FILES['user_image']['tmp_name']))){
                $manager = new ImageManager(new Driver());
                $pngImage=$manager->read(trim($_FILES['user_image']['tmp_name']))->cover(800,600)->encode(new PngEncoder(80));
                $webpImage=$manager->read(trim($_FILES['user_image']['tmp_name']))->cover(800,600)->encode(new WebpEncoder(80));
                $_POST['image']=$imageName;
                $savePicture=true;
            } else{
                $_POST['image']=$user->currentImage;
            }

            $_POST['status'] = "ACTIVE";
            $user->sincronize($_POST);
            
            $alerts = $user->validateAccount();

            if(empty($alerts)) {if($savePicture){

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
                $userExists = User::where('email', $user->email);

                if($userExists) {
                    User::setAlert('error', 'El Usuario ya esta registrado');
                    $alerts = User::getAlerts();
                } else {
                    // Hashear el password
                    $user->hashPassword();

                    // Eliminar password2
                    unset($user->password2);

                    // Generar el Token
                    $user->createToken();

                    // Crear un nuevo usuario
                    $resultado =  $user->saveElement();

                    // Enviar email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendConfirmation();
                    

                    if($resultado) {
                        header('Location: /message');
                    }
                }
            }
        }

        $router->render('auth/register', [
            'title' => 'Creación de cuenta',
            'user' => $user, 
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
                $user = User::where('email', $auth->email);

                if($user instanceof User && $user->confirmed && "ACTIVE" === strtoupper($user->status)) {

                    // Generar un nuevo token
                    $user->createToken();
                    unset($user->password2);

                    // Actualizar el usuario
                    $user->saveElement();

                    // Enviar el email
                    $email = new Email( $user->email, $user->name, $user->token );
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
        $user = User::where('token', $token);

        if(!$user instanceof User){
            User::setAlert('error', 'Usuario no válido');
            $alerts = User::getAlerts();
            // Muestra la vista
            $router->render('auth/reset', [
                'title' => 'Reestablecer contraseña',
                'alerts' => $alerts,
                'validToken' => $validToken
            ]);
        } else{
            if(empty($user)) {
                User::setAlert('error', 'Usuario no válido');
                $validToken = false;
            } else if("INACTIVE" === strtoupper($user->status)) {
                User::setAlert('error', 'Usuario inhabilitado');
                $validToken = false;
            }
            if('POST'===$_SERVER['REQUEST_METHOD']) {

                // Añadir el nuevo password
                $user->sincronize($_POST);
    
                // Validar el password
                $alerts = $user->validatePasswordRecovery();
    
                if(empty($alerts)) {
                    // Hashear el nuevo password
                    $user->hashPassword();
    
                    // Eliminar el Token
                    $user->token = null;
    
                    // Guardar el usuario en la BD
                    $resultado = $user->saveElement();
    
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
        $router->render('auth/message', [
            'title' => 'Cuenta creada exitosamente'
        ]);
    }

    public static function confirmaccount(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $user = User::where('token', $token);

        if(!$user instanceof User){
            User::setAlert('error', 'Token no válido, la cuenta no se confirmó');
        } else{
            if(empty($user)) {
                // No se encontró un usuario con ese token
                User::setAlert('error', 'Token no válido, la cuenta no se confirmó');
            } else if("INACTIVE" === strtoupper($user->status)) {
                // No se encontró un usuario con ese token
                User::setAlert('error', 'Usuario inhabilitado, la cuenta no se confirmó');
            } else {
                // Confirmar la cuenta
                $user->confirmed = 1;
                $user->token = '';
                unset($user->password2);
                
                // Guardar en la BD
                $user->saveElement();
    
                User::setAlert('success', 'Cuenta comprobada correctamente');
            }
        }

        $router->render('auth/confirm', [
            'title' => 'Confirma tu cuenta Funerales Fuentes',
            'alerts' => User::getAlerts()
        ]);
    }
}