<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::with(['user', 'bids', 'category'])
            ->whereNotNull('end_date')
            ->orderBy('end_date', 'asc')
            ->paginate(12);

        return view('auctions.mobile.index', compact('auctions'));
    }

    public function show(Auction $auction)
    {
        return view('auctions.mobile.show', compact('auction'));
    }
}
