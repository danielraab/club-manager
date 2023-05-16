<?php

use App\Models\UserPermission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('label');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        UserPermission::create([
            "id"=> UserPermission::ADMIN_USER,
            "label" => "Admin User.",
            "is_default" => false
        ]);

        UserPermission::create([
            "id"=> UserPermission::USER_MANAGEMENT,
            "label" => "Create users and update their permissions.",
            "is_default" => false
        ]);

        Schema::create('user_user_permission', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('user_permission_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_permission_id')->references('id')
                ->on('user_permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_user_permission');
        Schema::dropIfExists('user_permissions');
    }
};
