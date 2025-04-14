<?php

namespace App\Services;

use Brevo\Api\Api\TransactionalEmailsApi;
use Brevo\Client;
use Brevo\Model\SendSmtpEmail;

class SendinblueMailer
{
    protected $client;
    protected $apiInstance;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->getConfig()->setApiKey('api-key', config('services.sendinblue.api_key'));
        $this->apiInstance = new TransactionalEmailsApi($this->client);
    }

    public function send($to, $subject, $content)
    {
        $sendSmtpEmail = new SendSmtpEmail();
        $sendSmtpEmail->setSubject($subject);
        $sendSmtpEmail->setHtmlContent($content);
        $sendSmtpEmail->setTo([
            [
                'email' => $to,
                'name' => 'Admin'
            ]
        ]);
        $sendSmtpEmail->setSender([
            'email' => config('services.sendinblue.sender_email'),
            'name' => config('services.sendinblue.sender_name')
        ]);

        try {
            $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            \Log::error('Error al enviar correo con Sendinblue: ' . $e->getMessage());
            throw $e;
        }
    }
}
