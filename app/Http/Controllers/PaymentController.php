<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function checkout(Request $request, Auction $auction)
    {
        if ($auction->winner_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Solo el ganador puede realizar el pago.');
        }

        try {
            $stripe = new StripeClient(config('cashier.secret'));

            $checkout = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $auction->current_price * 100,
                        'product_data' => [
                            'name' => $auction->title,
                            'description' => 'Pago por subasta ganada',
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['auction' => $auction->id]),
                'cancel_url' => route('payment.cancel', ['auction' => $auction->id]),
            ]);

            return redirect($checkout->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function success(Request $request, Auction $auction)
    {
        $auction->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('auctions.show', $auction)
            ->with('success', '¡Pago realizado con éxito!');
    }

    public function cancel(Request $request, Auction $auction)
    {
        return redirect()->route('auctions.show', $auction)
            ->with('error', 'El pago ha sido cancelado.');
    }
}
