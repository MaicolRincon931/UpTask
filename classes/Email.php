<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'da4a4f32f05cc4';
        $mail->Password = 'ae07ed003d4b48';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        
        $contenido = '<html>
        <p> <strong>Hola '. $this->nombre.'</strong>
            Has creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace.
        </p>
        <p> Presiona Aquí: <a href="http://localhost:3000/confirmar?token='.$this->token.'"> 
            Confirmar Cuenta
        </a></p>
        <p>
            Si tu no creaste esta cuenta puedes ignorar este mensaje
        </p>
    </html>';

        $mail->Body = $contenido;
        $mail->send();
    }

    public function enviarInstrucciones()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'da4a4f32f05cc4';
        $mail->Password = 'ae07ed003d4b48';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Restablece tu password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        
        $contenido = '<html>
        <p> <strong>Hola '. $this->nombre.'</strong>
            Parece que has olvidado tu password, presiona el siguiente enlace para restablecerlo
        </p>
        <p> Presiona Aquí: <a href="http://localhost:3000/restablecer?token='.$this->token.'"> 
            Confirmar Cuenta
        </a></p>
        <p>
            Si tu no creaste esta cuenta puedes ignorar este mensaje
        </p>
    </html>';

        $mail->Body = $contenido;
        $mail->send();
    }
}
