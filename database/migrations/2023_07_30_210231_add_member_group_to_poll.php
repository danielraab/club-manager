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
        Schema::table('attendance_polls', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\MemberGroup::class, 'member_group_id')->nullable();
            $table->foreign('member_group_id')->references('id')->on('member_groups')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_polls', function (Blueprint $table) {
            $table->dropColumn('member_group_id');
        });
    }
};
