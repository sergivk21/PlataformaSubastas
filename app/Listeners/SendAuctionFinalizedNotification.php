<?php

namespace App\Listeners;

use App\Events\AuctionFinalized;
use App\Mail\AuctionFinalizedNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAuctionFinalizedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue;

    public function __construct()
    {
    }

    public function handle(AuctionFinalized $event): void
    {
        // Obtener todos los administradores
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        // Enviar email a cada administrador
        foreach ($admins as $admin) {
            Mail::to($admin)->send(new AuctionFinalizedNotification($event->auction));
        }
    }
}
