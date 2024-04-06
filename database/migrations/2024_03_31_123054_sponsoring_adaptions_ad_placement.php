<?php

use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\AdPlacement;
use App\Models\Sponsoring\Contract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//TODO move into sponsoring migration after live deployment
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sponsor_ad_placements', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Contract::class, 'contract_id');
            $table->foreign('contract_id')->references('id')->on('sponsor_contracts')->cascadeOnDelete();
            $table->foreignIdFor(AdOption::class, 'ad_option_id');
            $table->foreign('ad_option_id')->references('id')->on('sponsor_ad_options')->cascadeOnDelete();
            $table->unique(['contract_id', 'ad_option_id']);

            $table->boolean('done')->default(false);
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        \App\Models\UserPermission::create([
            'id' => AdPlacement::SPONSORING_EDIT_AD_PLACEMENTS,
            'label' => 'Edit sponsoring ad placement information',
            'is_default' => false,
        ]);

        Schema::table('sponsor_backers', function (Blueprint $table) {
            $table->string('website')->nullable()->after('email');
            $table->string('country')->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_ad_placements');
        \App\Models\UserPermission::find(AdPlacement::SPONSORING_EDIT_AD_PLACEMENTS)?->delete();
        Schema::dropColumns('sponsor_backers', ['website', 'country']);
    }
};
