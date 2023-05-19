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
        Schema::create('info_messages', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(true);
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->boolean('onlyInternal')->default(false);
            $table->dateTime('onDashboardUntil');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('last_updater_id')->nullable();
            $table->foreign('last_updater_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

        \App\Models\UserPermission::create([
            'id' => \App\Models\InfoMessage::INFO_MESSAGE_EDIT_PERMISSION,
            'label' => 'Create, edit and delete info messages',
            'is_default' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_message');
        \App\Models\UserPermission::find(\App\Models\InfoMessage::INFO_MESSAGE_EDIT_PERMISSION)?->delete();
    }
};
