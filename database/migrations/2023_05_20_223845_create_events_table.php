<?php

use App\Models\Event;
use App\Models\EventType;
use App\Models\User;
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
        Schema::create('event_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();

            $table->foreignId('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('event_types')->onDelete('set null');

            $table->smallInteger("sort_order")->default(0);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('location')->nullable();
            $table->string('dress_code')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('whole_day')->default(false);
            $table->boolean('enabled')->default(true);
            $table->boolean('logged_in_only')->default(false);
            $table->string('link')->nullable();

            $table->foreignIdFor(EventType::class)->nullable();
            $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('set null');

            $table->foreignIdFor(User::class, 'creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');

            $table->foreignIdFor(User::class, 'last_updater_id')->nullable();
            $table->foreign('last_updater_id')->references('id')->on('users')->onDelete('set null');

            $table->softDeletes();

            $table->timestamps();

            UserPermission::create([
                'id' => Event::EVENT_EDIT_PERMISSION,
                'label' => 'Create, edit and delete events and event types',
                'is_default' => false,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_types');
        UserPermission::find(Event::EVENT_EDIT_PERMISSION)?->delete();
    }
};
