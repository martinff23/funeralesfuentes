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

        $header = create_mail_header();
        $sign = create_mail_sign('Martín Fuentes Sánchez', 'martin.fuentes.sanchez@funeralesfuentes.com', ['+52 55 1132 8229', '+52 55 3728 2404']);

        $content = '<html>';
        $content .= '<body style="font-family: Charter, Georgia, serif; font-size: 16px; color: #333; background-image: url(' . $_ENV['HOST'] . '/build/img/golden_background.png); background-size: cover; background-repeat: no-repeat; background-position: center top; padding: 30px;">';
        $content .= $header;
        $content .= '<div style="background-color: transparent; padding: 20px; border-radius: 8px;">';
        $content .= "<p><strong>Hola " . $this->name .  "</strong></p>";
        $content .= "<p style='margin-top: 15px;'>Has registrado correctamente tu cuenta en Funerales Fuentes, pero es necesario confirmarla...</p>";
        $content .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/confirmAccount?token=" . $this->token . "' style='color: #0A1433; text-decoration: underline;'>Confirmar cuenta</a> para terminar el proceso.</p>";
        $content .= "<p>Si tu no creaste esta cuenta; puedes ignorar el mensaje.</p>";
        $content .= "<p>¡GRACIAS!<br>Atentamente,</p>";
        $content .= '</div>';
        $content .= $sign;
        $content .= '</body>';
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
        $mail->Subject = 'Reestablece tu contraseña';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $header = create_mail_header();
        $sign = create_mail_sign('Martín Fuentes Sánchez', 'martin.fuentes.sanchez@funeralesfuentes.com', ['+52 55 1132 8229', '+52 55 3728 2404']);


        $content = '<html>';
        $content .= '<body style="font-family: Charter, Georgia, serif; font-size: 16px; color: #333; background-image: url(' . $_ENV['HOST'] . '/build/img/golden_background.png); background-size: cover; background-repeat: no-repeat; background-position: center top; padding: 30px;">';
        $content .= $header;
        $content .= '<div style="background-color: transparent; padding: 20px; border-radius: 8px;">';
        $content .= "<p><strong>Hola " . $this->name .  "</strong></p>";
        $content .= "<p style='margin-top: 15px;'>Has solicitado reestablecer tu contraseña. Da click en el siguiente enlace para hacerlo.</p>";
        $content .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/reset?token=" . $this->token . "' style='color: #0A1433; text-decoration: underline;'>Reestablecer contraseña</a>.</p>";
        $content .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje.</p>";
        $content .= "<p>¡GRACIAS!<br>Atentamente,</p>";
        $content .= '</div>';
        $content .= $sign;
        $content .= '</body>';
        $content .= '</html>';
        $mail->Body = $content;

        //Enviar el mail
        $mail->send();
    }
}