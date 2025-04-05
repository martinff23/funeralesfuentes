<?php

namespace Controllers;

use Model\Service;
use Model\User;

class APIUsersController{

    public static function deleteUserN(){

        if('POST' === $_SERVER['REQUEST_METHOD']){
            $input = json_decode(file_get_contents('php://input'), true);
            error_log('INPUT: ' . print_r($input, true));
            $user = User::find($input['id']);
            if($user){
                $result = $user->deleteNElement();
                if ($result) {
                    echo json_encode(['message' => 'Contacto eliminado correctamente']);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Error al procesar la solicitud']);
                }
            } else{
                http_response_code(500);
                echo json_encode(['message' => 'Usuario no encontrado']);
            }
        } else{
            http_response_code(500);
            echo json_encode(['message' => 'Metodo incorrecto']);
        }
        
    }
}