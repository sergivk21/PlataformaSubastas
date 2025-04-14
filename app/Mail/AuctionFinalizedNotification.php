<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionFinalizedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Auction $auction)
    {
    }

    public function build()
    {
        return $this->markdown('emails.auction-finalized')
            ->subject('Subasta Finalizada')
            ->with([
                'auction' => $this->auction,
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'environment' => config('app.env')
            ]);
    }
}
