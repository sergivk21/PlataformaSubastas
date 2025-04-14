<?php

namespace App\Policies;

use App\Models\Auction;
use App\Models\User;

class AuctionPolicy
{
    public function update(User $user, Auction $auction): bool
    {
        return $user->id === $auction->user_id;
    }

    public function delete(User $user, Auction $auction): bool
    {
        return $user->id === $auction->user_id;
    }

    public function bid(User $user, Auction $auction): bool
    {
        return $user->id !== $auction->user_id && 
               $auction->status === 'active' &&
               now()->lt($auction->end_date);
    }
}
