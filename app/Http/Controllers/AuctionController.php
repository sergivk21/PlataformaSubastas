<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuctionController extends Controller
{
    public function index()
    {
        // Obtener todas las subastas ordenadas por fecha de fin
        $auctions = Auction::with(['user', 'bids', 'category'])
            ->whereNotNull('end_date')
            ->orderBy('end_date', 'asc')
            ->paginate(12);

        // Log para depurar
        Log::info('Subastas en index:', [
            'count' => $auctions->total(),
            'auctions' => $auctions->map(function ($auction) {
                return [
                    'id' => $auction->id,
                    'title' => $auction->title,
                    'status' => $auction->status,
                    'end_date' => $auction->end_date->format('Y-m-d H:i:s'),
                    'created_at' => $auction->created_at->format('Y-m-d H:i:s')
                ];
            })->toArray()
        ]);

        return view('auctions.index', compact('auctions'));
    }

    public function create()
    {
        return view('auctions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'end_date' => 'required|date|after:now',
        ]);

        DB::beginTransaction();
        try {
            $auction = new Auction([
                'title' => $request->title,
                'description' => $request->description,
                'starting_price' => $request->starting_price,
                'current_price' => $request->starting_price,
                'end_date' => $request->end_date,
                'status' => 'active',
                'user_id' => Auth::id(),
            ]);

            $auction->save();

            DB::commit();
            return redirect()->route('auctions.index')->with('success', 'Subasta creada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear la subasta')->withInput();
        }
    }

    public function show(Auction $auction)
    {
        // Verificar si la subasta existe
        if (!$auction) {
            abort(404, 'Subasta no encontrada');
        }

        // Cargar relaciones necesarias
        $auction->load(['user', 'bids.user']);

        // Obtener la puja más alta
        $highestBid = $auction->bids()->orderBy('amount', 'desc')->first();

        // Verificar si el usuario es el ganador
        $isWinner = auth()->check() && 
                    $auction->hasWinner() && 
                    $auction->winner_id === auth()->id();

        // Verificar si el usuario es el vendedor
        $isSeller = auth()->check() && 
                    $auction->user_id === auth()->id();

        // Verificar si el usuario ha pujado
        $hasBid = auth()->check() && 
                 $auction->bids()->where('user_id', auth()->id())->exists();

        return view('auctions.show', [
            'auction' => $auction,
            'highestBid' => $highestBid,
            'isWinner' => $isWinner,
            'isSeller' => $isSeller,
            'hasBid' => $hasBid
        ]);
    }

    public function edit(Auction $auction)
    {
        return view('auctions.edit', compact('auction'));
    }

    public function update(Request $request, Auction $auction)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date|after:now',
        ]);

        $auction->update($request->all());

        return redirect()->route('auctions.show', $auction)
            ->with('success', '¡Subasta actualizada exitosamente!');
    }

    public function finalize(Auction $auction)
    {
        $auction->finalize();
        
        return redirect()->route('auctions.index')
            ->with('success', '¡Subasta finalizada exitosamente!');
    }

    public function destroy(Auction $auction)
    {
        $auction->delete();

        return redirect()->route('auctions.index')
            ->with('success', '¡Subasta eliminada exitosamente!');
    }

    public function deleteAll(Request $request)
    {
        $this->authorize('admin');

        Auction::where('status', 'active')->delete();
        return redirect()->route('auctions.index')->with('success', 'Todas las subastas han sido eliminadas exitosamente');
    }

    public function testActiveAuctions()
    {
        $activeAuctions = Auction::where('status', 'active')
            ->whereNotNull('end_date')
            ->where('end_date', '>', now())
            ->get();

        Log::info('Subastas activas:', [
            'count' => $activeAuctions->count(),
            'auctions' => $activeAuctions->map(function ($auction) {
                return [
                    'id' => $auction->id,
                    'title' => $auction->title,
                    'status' => $auction->status,
                    'end_date' => $auction->end_date->format('Y-m-d H:i:s'),
                    'created_at' => $auction->created_at->format('Y-m-d H:i:s')
                ];
            })->toArray()
        ]);

        return response()->json($activeAuctions);
    }
}
