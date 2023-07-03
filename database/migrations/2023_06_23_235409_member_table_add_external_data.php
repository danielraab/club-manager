<?php

use App\Models\Import\ImportedMember;
use App\Models\UserPermission;
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
        Schema::table('members', function (Blueprint $table) {
            $table->string('external_id')->unique()->nullable();
            $table->dateTime('last_import_date')->nullable();
        });

        UserPermission::create([
            'id' => ImportedMember::MEMBER_IMPORT_PERMISSION,
            'label' => 'Import members via list',
            'is_default' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('external_id');
            $table->dropColumn('last_import_date');
        });

        UserPermission::find(ImportedMember::MEMBER_IMPORT_PERMISSION)?->delete();
    }
};
