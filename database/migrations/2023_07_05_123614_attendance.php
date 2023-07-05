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
            $table->uuid('id');
            $table->boolean('enabled')->default(true);
            $table->boolean('allow_anonymous_vote')->default(false);
            $table->string('allowed_answer_set')->nullable();
            $table->dateTime('closing_at')->nullable();

            $table->primary('id');

            $table->timestamps();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->foreignIdFor(Event::class, 'event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $table->foreignIdFor(Member::class, 'member_id');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

            $table->smallInteger('poll_status',false, true)->nullable();
            $table->smallInteger('final_status',false, true)->nullable();

            $table->primary(["event_id", "member_id"]);

            $table->foreignIdFor(User::class, 'creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');

            $table->foreignIdFor(User::class, 'last_updater_id')->nullable();
            $table->foreign('last_updater_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });


        Schema::create('event_attendance_poll', function (Blueprint $table) {
            $table->foreignIdFor(Event::class, 'event_id');
            $table->foreignUuid('attendance_poll_id');
            $table->foreign('event_id')->references('id')
                ->on('events')->onDelete('cascade');
            $table->foreign('attendance_poll_id')->references('id')
                ->on('attendance_polls')->onDelete('cascade');
        });

        \App\Models\UserPermission::create([
            'id' => Attendance::ATTENDANCE_EDIT_PERMISSION,
            'label' => 'Set and edit attendance to a event, unregarded to a poll',
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

        \App\Models\UserPermission::find(Attendance::ATTENDANCE_EDIT_PERMISSION)?->delete();
        \App\Models\UserPermission::find(AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION)?->delete();
    }
};
