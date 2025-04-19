<?php

namespace Controllers;

use Model\Contact;

class APIContactController{

    public static function contact(){

        if('POST' === $_SERVER['REQUEST_METHOD']){
            $contact = new Contact();

            $input = json_decode(file_get_contents('php://input'), true);
            
            if (empty($input['name']) || empty($input['telephone']) || empty($input['email'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Todos los campos son obligatorios']);
                exit;
            }

            $_POST = [
                'name' => $input['name'],
                'telephone' => $input['telephone'],
                'email' => $input['email'],
            ];

            $_POST['status'] = "ACTIVE";
            $_POST['assignee'] = 0;
            $_POST['entered_date'] = date('Y-m-d');
            $_POST['closed_date'] = '9999/12/31';
            $contact->sincronize($_POST);
            $alerts = $contact->validate();
            if(empty($alerts)){
                $result = $contact->saveElement();
                if ($result) {
                    echo json_encode(['message' => 'Contacto guardado']);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Error al guardar la solicitud']);
                }
            } else{
                http_response_code(500);
                $alertsString = '';
                foreach($alerts as $alert){
                    $alertsString .= " | " . $alert .  " | ";
                }
                echo json_encode(['message' => 'Error al guardar la solicitud - Alertas: '.$alertsString]);
            }
        }
    }

}