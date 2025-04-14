<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class HotmailSmtpMailer
{
    public function send($to, $subject, $content)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = config('services.hotmail.username');
            $mail->Password = config('services.hotmail.password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            // Ajustes adicionales para Office 365
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Remitente
            $mail->setFrom(config('services.hotmail.username'), config('services.hotmail.sender_name'));

            // Destinatario
            $mail->addAddress($to);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $subject;
            
            $htmlContent = "
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { color: #2c3e50; margin-bottom: 20px; }
                        .content { margin-bottom: 20px; }
                        .footer { color: #666; font-size: 12px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'><h1>$subject</h1></div>
                        <div class='content'>$content</div>
                        <div class='footer'>
                            <hr>
                            <p>{{ config('app.name') }}<br>
                            {{ config('app.url') }}<br>
                            {{ now()->format('Y') }}</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            $mail->Body = $htmlContent;

            $mail->send();
        } catch (Exception $e) {
            \Log::error('Error al enviar correo: ' . $e->getMessage());
            \Log::error('Detalles del error: ' . $mail->ErrorInfo);
            throw $e;
        }
    }
}
