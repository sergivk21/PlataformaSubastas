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
        $now = now();
        $auctions = Auction::with(['user', 'bids', 'category'])
            ->whereNotNull('end_date')
            ->orderByRaw(
                "CASE WHEN status = 'active' AND end_date > ? THEN 0 ELSE 1 END ASC",
                [$now]
            )
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
        // Permitir crear subastas si tiene el rol seller o admin
        if (!auth()->user()->hasAnyRole(['seller', 'admin'])) {
            return redirect()->route('auctions.index')->with('error', 'No tienes permisos para crear subastas.');
        }
        return view('auctions.create');
    }

    public function store(Request $request)
    {
        try {
            // Validar los datos
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'starting_price' => 'required|numeric|min:0',
                'end_date' => 'required|date|after:now',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Iniciar transacción
            DB::beginTransaction();

            // Crear la subasta
            $auction = new Auction([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'starting_price' => $validated['starting_price'],
                'current_price' => $validated['starting_price'],
                'end_date' => $validated['end_date'],
                'status' => 'active',
                'user_id' => Auth::id(),
            ]);

            // Manejar la imagen si se subió
            if ($request->hasFile('image')) {
                // Guardar la imagen
                $imagePath = $request->file('image')->store('auctions', 'public');
                $auction->image = basename($imagePath);
            }

            // Guardar la subasta
            $auction->save();

            // Confirmar transacción
            DB::commit();

            // Redirigir con éxito
            return redirect()->route('auctions.index')
                ->with('success', 'Subasta creada exitosamente');

        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            DB::rollBack();
            
            // Log del error
            Log::error('Error al crear subasta: ' . $e->getMessage());
            
            // Redirigir con error
            return redirect()->back()
                ->with('error', 'Error al crear la subasta. Por favor, inténtalo de nuevo.')
                ->withInput($request->except('image')); // No mantener la imagen en los datos
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

        // Obtener la puja más alta del usuario actual si existe
        $userBid = null;
        if (auth()->check()) {
            $userBid = $auction->bids()
                ->where('user_id', auth()->id())
                ->orderBy('amount', 'desc')
                ->first();
        }

        // Verificar si el usuario ha pujado
        $hasBid = $userBid !== null;

        return view('auctions.show', [
            'auction' => $auction,
            'highestBid' => $highestBid,
            'userBid' => $userBid,
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
