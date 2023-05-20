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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(true);
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->boolean('logged_in_only')->default(false);
            $table->dateTime('display_until');
            $table->foreignIdFor(\App\Models\User::class, 'creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->foreignIdFor(\App\Models\User::class, 'last_updater_id')->nullable();
            $table->foreign('last_updater_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

        \App\Models\UserPermission::create([
            'id' => \App\Models\News::NEWS_EDIT_PERMISSION,
            'label' => 'Create, edit and delete news',
            'is_default' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
        \App\Models\UserPermission::find(\App\Models\News::NEWS_EDIT_PERMISSION)?->delete();
    }
};
