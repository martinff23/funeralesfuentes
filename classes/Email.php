<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $name;
    public $token;
    
    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation() {

         // create a new object
         $mail = new PHPMailer(true);
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('contacto@funeralesfuentes.com');
         $mail->addAddress($this->email, $this->name);
         $mail->Subject = 'Confirma tu Cuenta';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $content = '<html>';
         $content .= "<p><strong>Hola " . $this->name .  "</strong> Has Registrado Correctamente tu cuenta en Funerales Fuentes; pero es necesario confirmarla</p>";
         $content .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/confirmAccount?token=" . $this->token . "'>Confirmar Cuenta</a>";       
         $content .= "<p>Si tu no creaste esta cuenta; puedes ignorar el mensaje</p>";
         $content .= '</html>';
         $mail->Body = $content;

         //Enviar el mail
         $mail->send();

    }

    public function sendInstructions() {

        // create a new object
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('contacto@funeralesfuentes.com');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = 'Reestablece tu password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= "<p><strong>Hola " . $this->name .  "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $content .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/reset?token=" . $this->token . "'>Reestablecer Password</a>";        
        $content .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $content .= '</html>';
        $mail->Body = $content;

        //Enviar el mail
        $mail->send();
    }
}