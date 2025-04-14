<?php

namespace App\Services;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Config;

class HotmailMailer
{
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($view, $data = [], $callback = null)
    {
        // Configurar el mailer para usar Hotmail
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', 'smtp.office365.com');
        Config::set('mail.mailers.smtp.port', 587);
        Config::set('mail.mailers.smtp.encryption', 'tls');
        Config::set('mail.mailers.smtp.username', env('MAIL_USERNAME'));
        Config::set('mail.mailers.smtp.password', env('MAIL_PASSWORD'));
        Config::set('mail.from.address', env('MAIL_FROM_ADDRESS'));
        Config::set('mail.from.name', env('MAIL_FROM_NAME'));

        return $this->mailer->send($view, $data, $callback);
    }
}
