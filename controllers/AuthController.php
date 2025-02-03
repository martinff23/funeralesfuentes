<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class AuthController {
    public static function login(Router $router) {

        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $user = new User($_POST);

            $alerts = $user->validateLogin();
            
            if(empty($alerts)) {
                // Verificar quel el usuario exista
                $user = User::where('email', $user->email);
                if(!$user || !$user->confirmed ) {
                    User::setAlert('error', 'El Usuario No Existe o no esta confirmado');
                } else {
                    // El Usuario existe
                    if( password_verify($_POST['password'], $user->password) ) {
                        
                        // Iniciar la sesión
                        session_start();    
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['f_name'] = $user->f_name;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['admin'] = $user->admin ?? null;
                        
                    } else {
                        User::setAlert('error', 'Password Incorrecto');
                    }
                }
            }
        }

        $alerts = User::getAlerts();
        
        // Render a la vista 
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alerts
        ]);
    }

    public static function logout() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
       
    }

    public static function register(Router $router) {
        $alerts = [];
        $user = new User;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user->sincronize($_POST);
            
            $alerts = $user->validateAccount();

            if(empty($alerts)) {
                $existeUsuario = User::where('email', $user->email);

                if($existeUsuario) {
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
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/registro', [
            'titulo' => 'Crea tu cuenta en DevWebcamp',
            'usuario' => $user, 
            'alertas' => $alerts
        ]);
    }

    public static function forgot(Router $router) {
        $alerts = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alerts = $user->validateEmail();

            if(empty($alerts)) {
                // Buscar el usuario
                $user = User::where('email', $user->email);

                if($user && $user->confirmed) {

                    // Generar un nuevo token
                    $user->createToken();
                    unset($user->password2);

                    // Actualizar el usuario
                    $user->saveElement();

                    // Enviar el email
                    $email = new Email( $user->email, $user->name, $user->token );
                    $email->sendInstructions();


                    // Imprimir la alerta
                    // Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');

                    $alerts['exito'][] = 'Hemos enviado las instrucciones a tu email';
                } else {
                 
                    // Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');

                    $alerts['error'][] = 'El Usuario no existe o no esta confirmado';
                }
            }
        }

        // Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alerts
        ]);
    }

    public static function reset(Router $router) {

        $token = s($_GET['token']);

        $token_valido = true;

        if(!$token) header('Location: /');

        // Identificar el usuario con este token
        $user = User::where('token', $token);

        if(empty($user)) {
            User::setAlert('error', 'Token No Válido, intenta de nuevo');
            $token_valido = false;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Añadir el nuevo password
            $user->sincronize($_POST);

            // Validar el password
            $alerts = $user->validatePassword();

            if(empty($alerts)) {
                // Hashear el nuevo password
                $user->hashPassword();

                // Eliminar el Token
                $user->token = null;

                // Guardar el usuario en la BD
                $resultado = $user->saveElement();

                // Redireccionar
                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alerts = User::getAlerts();
        
        // Muestra la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alerts,
            'token_valido' => $token_valido
        ]);
    }

    public static function message(Router $router) {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirm(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $user = User::where('token', $token);

        if(empty($user)) {
            // No se encontró un usuario con ese token
            User::setAlert('error', 'Token No Válido');
        } else {
            // Confirmar la cuenta
            $user->confirmed = 1;
            $user->token = '';
            unset($user->password2);
            
            // Guardar en la BD
            $user->saveElement();

            User::setAlert('exito', 'Cuenta Comprobada Correctamente');
        }

     

        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta DevWebcamp',
            'alertas' => User::getAlerts()
        ]);
    }
}