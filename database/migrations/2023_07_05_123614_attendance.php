<?php

use App\Models\Attendance;
use App\Models\AttendancePoll;
use App\Models\Event;
use App\Models\Member;
use App\Models\User;
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
        Schema::create('attendance_polls', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->string('description')->nullable();

            $table->boolean('allow_anonymous_vote')->default(false);
            $table->dateTime('closing_at')->nullable();

            $table->foreignIdFor(User::class, 'creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'last_updater_id')->nullable();
            $table->foreign('last_updater_id')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Event::class, 'event_id');
            $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
            $table->foreignIdFor(Member::class, 'member_id');
            $table->foreign('member_id')->references('id')->on('members')->cascadeOnDelete();
            $table->unique(['event_id', 'member_id']);

            $table->enum('poll_status',
                ['in', 'out', 'unsure'])->nullable();
            $table->boolean('attended')->nullable();

            $table->foreignIdFor(User::class, 'creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'last_updater_id')->nullable();
            $table->foreign('last_updater_id')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('attendance_poll_event', function (Blueprint $table) {
            $table->foreignIdFor(Event::class, 'event_id');
            $table->foreignIdFor(AttendancePoll::class, 'attendance_poll_id');
            $table->foreign('event_id')->references('id')
                ->on('events')->cascadeOnDelete();
            $table->foreign('attendance_poll_id')->references('id')
                ->on('attendance_polls')->cascadeOnDelete();
        });

        \App\Models\UserPermission::create([
            'id' => Attendance::ATTENDANCE_SHOW_PERMISSION,
            'label' => 'Show attendance to a event',
            'is_default' => false,
        ]);

        \App\Models\UserPermission::create([
            'id' => Attendance::ATTENDANCE_EDIT_PERMISSION,
            'label' => 'Set and edit attendance to a event, unregarded to a poll',
            'is_default' => false,
        ]);

        \App\Models\UserPermission::create([
            'id' => AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION,
            'label' => 'Show attendance polls and their summary. For showing the detailed attendances the additional permission is required.',
            'is_default' => false,
        ]);

        \App\Models\UserPermission::create([
            'id' => AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION,
            'label' => 'Create and update attendance polls',
            'is_default' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_poll');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('event_attendance_poll');

        \App\Models\UserPermission::find(Attendance::ATTENDANCE_EDIT_PERMISSION)?->delete();
        \App\Models\UserPermission::find(AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION)?->delete();
    }
};
