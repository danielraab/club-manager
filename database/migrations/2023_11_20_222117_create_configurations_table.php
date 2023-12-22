<?php

use App\Models\User;
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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();

            $table->string('key');
            $table->string('value');
            $table->enum('datatype', ['string', 'int', 'bool']);

            $table->foreignIdFor(User::class)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->unique(['key', 'user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
