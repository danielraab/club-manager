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
        Schema::table('members', function(Blueprint $table) {
            $table->string("external_id")->unique()->nullable();
            $table->dateTime("last_import_date")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function(Blueprint $table) {
            $table->dropColumn("external_id");
            $table->dropColumn("last_import_date");
        });
    }
};
