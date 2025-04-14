<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('starting_price', 10, 2);
            $table->decimal('current_price', 10, 2);
            $table->timestamp('start_date')->useCurrent();
            $table->timestamp('end_date')->nullable();
            $table->enum('status', ['pending', 'active', 'finished', 'cancelled'])->default('pending');
            $table->foreignId('winner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
