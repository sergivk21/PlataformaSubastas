<?php

namespace App\Mail;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBidNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bid;

    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }

    public function build()
    {
        return $this->view('emails.new-bid', [
            'bid' => $this->bid,
            'auction' => $this->bid->auction,
            'user' => $this->bid->user,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'environment' => config('app.env')
        ])
        ->subject('Nueva Puja en Subasta: ' . $this->bid->auction->title);
    }
}
