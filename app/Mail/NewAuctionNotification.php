<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAuctionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function build()
    {
        return $this->view('emails.new-auction', [
            'auction' => $this->auction,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'environment' => config('app.env')
        ])
        ->subject('Nueva Subasta Creada: ' . $this->auction->title);
    }
}
