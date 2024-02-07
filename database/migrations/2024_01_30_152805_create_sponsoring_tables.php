<?php

use App\Models\Sponsoring\Backer;
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
        Schema::create('sponsor_backers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('street')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->text('info')->nullable();
            $table->date('closed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('sponsor_ad_options', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text('description')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();
        });

        Schema::create('sponsor_packages', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text('description')->nullable();
            $table->boolean('is_official')->default(false);
            $table->float('price');
            $table->timestamps();
        });

        // n:m table ad_option_sponsor_packages


        Schema::create('sponsor_periods', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text('description')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamps();
        });

        // n:m table available Packages sponsor_period_sponsor_packages


        /*
         * sponsorPackage_id can be null
         * if isRefused is false -> waiting for member response
         * - on member response select package or set isRefused to true
         */
        Schema::create('sponsor_contracts', function (Blueprint $table) {
            $table->id();
            //backer_id
            //sponsor_period_id
            //sponsor_package_id
            //member_id
            $table->text('info')->nullable();
            $table->boolean('is_refused')->default(false);
            $table->boolean('is_contract_received')->default(false);
            $table->boolean('is_ad_data_received')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });


        \App\Models\UserPermission::create([
            'id' => Backer::SPONSORING_EDIT_PERMISSION,
            'label' => 'Edit sponsoring data',
            'is_default' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backers');
        Schema::dropIfExists('sponsor_ad_options');
        Schema::dropIfExists('sponsor_packages');
        Schema::dropIfExists('sponsor_periods');
        Schema::dropIfExists('sponsor_contracts');

        \App\Models\UserPermission::find(Backer::SPONSORING_EDIT_PERMISSION)?->delete();

    }
};
