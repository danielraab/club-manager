<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//TODO move into sponsoring migration after live deployment
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::connection(config('webpush.database_connection'))->table(config('webpush.table_name'), function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class, 'user_id')->after('id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('webpush.database_connection'))->dropColumns(config('webpush.table_name'),'user_id');
    }
};
