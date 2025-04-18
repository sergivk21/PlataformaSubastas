<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction)
    {
        // Verificar si el usuario es administrador
        if (auth()->user()->hasRole('admin')) {
            return redirect()->back()
                ->with('error', 'Los administradores no pueden realizar pujas.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:' . ($auction->current_price + 1),
        ], [
            'amount.required' => 'El monto de la puja es requerido.',
            'amount.numeric' => 'El monto de la puja debe ser un número.',
            'amount.min' => 'La puja debe ser mayor que el precio actual.',
        ]);

        DB::beginTransaction();
        try {
            $bid = new Bid([
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'auction_id' => $auction->id,
            ]);

            $bid->save();

            // Actualizar el precio actual de la subasta
            $auction->current_price = $request->amount;
            $auction->save();

            DB::commit();

            // Redirección según origen (móvil o escritorio)
            if (request()->is('mobile/*') || str_contains(url()->previous(), '/mobile/')) {
                return redirect()->route('auctions.mobile.show', $auction)
                    ->with('success', 'Puja realizada exitosamente');
            } else {
                return redirect()->route('auctions.show', $auction)
                    ->with('success', 'Puja realizada exitosamente');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al realizar la puja')
                ->withInput();
        }
    }
}
