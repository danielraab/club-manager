<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any NULL values to 0
        DB::table('sponsor_packages')
            ->whereNull('price')
            ->update(['price' => 0]);

        Schema::table('sponsor_packages', function (Blueprint $table) {
            $table->float('price')->default(0)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsor_packages', function (Blueprint $table) {
            $table->float('price')->nullable()->change();
        });
    }
};
