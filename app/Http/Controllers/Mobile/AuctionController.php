<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        $now = now();
        $auctions = Auction::with(['user', 'bids', 'category'])
            ->whereNotNull('end_date')
            ->orderByRaw(
                "CASE WHEN status = 'active' AND end_date > ? THEN 0 ELSE 1 END ASC",
                [$now]
            )
            ->orderBy('end_date', 'asc')
            ->paginate(12);

        return view('auctions.mobile.index', compact('auctions'));
    }

    public function show(Auction $auction)
    {
        return view('auctions.mobile.show', compact('auction'));
    }

    public function create()
    {
        return view('auctions.mobile.create');
    }

    public function store(Request $request)
    {
        // Permitir crear subastas si tiene el rol seller o admin
        if (!auth()->user()->hasAnyRole(['seller', 'admin'])) {
            return redirect()->route('auctions.mobile.index')->with('error', 'No tienes permisos para crear subastas.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'end_date' => 'required|date|after:now',
            'image' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);

        $auction = new \App\Models\Auction();
        $auction->title = $validated['title'];
        $auction->description = $validated['description'];
        $auction->starting_price = $validated['starting_price'];
        $auction->end_date = $validated['end_date'];
        $auction->user_id = auth()->id();

        // Imagen
        if ($request->hasFile('image')) {
            $auction->image = $request->file('image')->store('auctions', 'public');
        }

        $auction->save();

        return redirect()->route('auctions.mobile.index')->with('success', 'Subasta creada correctamente.');
    }

    public function destroy(Auction $auction)
    {
        // Solo el admin o el creador puede borrar
        if (!auth()->user()->hasRole('admin') && $auction->user_id !== auth()->id()) {
            abort(403);
        }
        // Borra la imagen si existe
        if ($auction->image) {
            \Storage::disk('public')->delete($auction->image);
        }
        $auction->delete();
        return redirect()->route('auctions.mobile.index')->with('success', 'Subasta eliminada correctamente.');
    }
}
