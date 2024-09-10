<?php

use App\Models\MemberGroup;
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
        Schema::table('events', function (Blueprint $table) {
            $table->foreignIdFor(MemberGroup::class)->nullable()->after('link');
            $table->foreign('member_group_id')->references('id')->on('member_groups')->onDelete('set null');

            $table->dropColumn('logged_in_only');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('member_group_id');

            $table->boolean('logged_in_only')->default(false)->after('enabled');
        });
    }
};
