<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//TODO move to sponsoring after deployed on all systems
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sponsor_backers', function (Blueprint $table) {
            $table->string('vat')->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsor_backers', function (Blueprint $table) {
            $table->dropColumn('vat');
        });
    }
};
