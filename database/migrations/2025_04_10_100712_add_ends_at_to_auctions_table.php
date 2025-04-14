<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dateTime('ends_at')->nullable()->after('status');
        });

        // Actualizar las subastas existentes con una fecha de finalización
        Schema::table('auctions', function (Blueprint $table) {
            $table->dateTime('ends_at')->nullable()->change();
        });

        // Actualizar las subastas existentes con una fecha de finalización
        \DB::table('auctions')
            ->where('status', 'finished')
            ->update(['ends_at' => \DB::raw('NOW()')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('ends_at');
        });
    }
};
