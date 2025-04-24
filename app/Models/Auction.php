<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Auction extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'starting_price',
        'current_price',
        'start_date',
        'end_date',
        'status',
        'winner_id',
        'paid_at',
        'category_id',
        'image'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'paid_at' => 'datetime'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Si ya contiene 'auctions/', úsalo tal cual. Si no, prepéndelo.
            $path = str_starts_with($this->image, 'auctions/') ? $this->image : 'auctions/' . $this->image;
            return asset('storage/' . $path);
        }
        return asset('images/default-auction.jpg');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function highestBid()
    {
        return $this->bids()->orderBy('amount', 'desc')->first();
    }

    public function isFinished(): bool
    {
        return $this->status === 'finished';
    }

    public function hasWinner(): bool
    {
        return $this->winner_id !== null;
    }

    public function getStatusAttribute($value)
    {
        if ($this->end_date && $this->end_date <= now()) {
            return 'finished';
        }
        return $value;
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->end_date !== null && 
               $this->end_date->gt(now());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->whereNotNull('end_date')
                     ->where('end_date', '>', now());
    }

    public function scopeFinished($query)
    {
        return $query->whereNotNull('end_date')
                     ->where('end_date', '<=', now());
    }

    public function getWinner(): ?User
    {
        if ($this->hasWinner()) {
            return User::find($this->winner_id);
        }
        return null;
    }

    public function finalize(): void
    {
        // Verificar si la subasta ya está finalizada
        if ($this->status === 'finished') {
            return;
        }

        // Verificar si hay una fecha de fin válida
        if (!$this->end_date) {
            $this->end_date = now();
        }

        // Verificar si la fecha de fin ya pasó
        if ($this->end_date->isPast()) {
            $this->status = 'finished';
            $highestBid = $this->highestBid();

            if ($highestBid) {
                $this->winner_id = $highestBid->user_id;
            }

            $this->save();
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($auction) {
            $auction->status = 'active';
            $auction->current_price = $auction->starting_price;
        });
    }
}
