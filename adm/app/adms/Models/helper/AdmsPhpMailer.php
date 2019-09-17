<?php

namespace App\adms\Models\helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!defined('URL')) {
    header("Location: /");
    exit();
}



class AdmsPhpMailer
{

    private $Resultado;

    public function emailPhpMailer($Dados)
    {
        $mail = new PHPMailer(true);                              
        try {
                                           
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'email';                 // SMTP username
            $mail->Password = '';                           // SMTP password
            $mail->SMTPSecure = 'tsl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            
            //Recipients
            $mail->setFrom('@gmail.com', 'danilo');
            $mail->addAddress('@gmail.com', 'es');     // Add a recipient
            //
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Confirmar e-mail';
            $mail->Body = 'Mensagem em html <b>negrito!</b>';
            $mail->AltBody = 'Mensagem somente texto';

            if($mail->send()){
                echo 'Messagem enviada com sucesso';
            }else{
                echo 'Erro a messagem não foi enviada com sucesso';
            }
            
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

}
