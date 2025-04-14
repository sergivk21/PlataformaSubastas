<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkerDownNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function build()
    {
        return $this->markdown('emails.worker-down')
            ->subject('Alerta: Servicio de Worker Detenido')
            ->with([
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'environment' => config('app.env')
            ]);
    }
}
