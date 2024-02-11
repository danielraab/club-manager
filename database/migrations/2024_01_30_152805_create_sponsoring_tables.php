<?php

use App\Models\Member;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;
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
            $table->boolean("enabled")->default(true);
            $table->string("name");
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('street')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->text('info')->nullable();
            $table->date('closed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sponsor_ad_options', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text('description')->nullable();
            $table->float('price')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sponsor_packages', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text('description')->nullable();
            $table->boolean('is_official')->default(false);
            $table->float('price');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sponsor_package_sponsor_ad_option', function (Blueprint $table) {
            $table->foreignIdFor(Package::class, 'package_id');
            $table->foreignIdFor(\App\Models\Sponsoring\AdOption::class, 'ad_option_id');
            $table->foreign('package_id')->references('id')
                ->on('sponsor_packages')->cascadeOnDelete();
            $table->foreign('ad_option_id')->references('id')
                ->on('sponsor_ad_options')->cascadeOnDelete();
        });

        Schema::create('sponsor_periods', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text('description')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sponsor_period_sponsor_package', function (Blueprint $table) {
            $table->foreignIdFor(Period::class, 'period_id');
            $table->foreignIdFor(Package::class, 'package_id');
            $table->foreign('period_id')->references('id')
                ->on('sponsor_periods')->cascadeOnDelete();
            $table->foreign('package_id')->references('id')
                ->on('sponsor_packages')->cascadeOnDelete();
        });

        /*
         * sponsorPackage_id can be null
         * if isRefused is false -> waiting for member response
         * - on member response select package or set isRefused to true
         */
        Schema::create('sponsor_contracts', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Period::class, 'period_id');
            $table->foreign('period_id')->references('id')->on('sponsor_periods')->cascadeOnDelete();
            $table->foreignIdFor(Backer::class, 'backer_id');
            $table->foreign('backer_id')->references('id')->on('sponsor_backers')->cascadeOnDelete();
            $table->foreignIdFor(Member::class, 'member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->cascadeOnDelete();
            $table->foreignIdFor(Package::class, 'package_id')->nullable();
            $table->foreign('package_id')->references('id')->on('sponsor_packages')->cascadeOnDelete();

            $table->text('info')->nullable();
            $table->dateTime('refused')->nullable();
            $table->dateTime('contract_received')->nullable();
            $table->dateTime('ad_data_received')->nullable();
            $table->dateTime('paid')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });


        \App\Models\UserPermission::create([
            'id' => Contract::SPONSORING_SHOW_PERMISSION,
            'label' => 'Show sponsoring data',
            'is_default' => false,
        ]);

        \App\Models\UserPermission::create([
            'id' => Contract::SPONSORING_EDIT_PERMISSION,
            'label' => 'Edit sponsoring data',
            'is_default' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_package_sponsor_ad_option');
        Schema::dropIfExists('sponsor_period_sponsor_package');
        Schema::dropIfExists('backers');
        Schema::dropIfExists('sponsor_ad_options');
        Schema::dropIfExists('sponsor_packages');
        Schema::dropIfExists('sponsor_periods');
        Schema::dropIfExists('sponsor_contracts');

        \App\Models\UserPermission::find(Contract::SPONSORING_SHOW_PERMISSION)?->delete();
        \App\Models\UserPermission::find(Contract::SPONSORING_EDIT_PERMISSION)?->delete();

    }
};
