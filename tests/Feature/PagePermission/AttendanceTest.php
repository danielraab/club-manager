<?php

namespace Tests\Feature\PagePermission;

use App\Models\Attendance;
use App\Models\AttendancePoll;
use App\Models\Event;
use App\Models\UserPermission;

class AttendanceTest extends TestPagePermission
{
    private string $pollId = '';

    protected function doAdditionalSeeds(): void
    {
        $event = Event::factory()->create();
        $poll = AttendancePoll::factory()->create([
            'allow_anonymous_vote' => true,
            'show_public_stats' => true,
        ]);
        $this->pollId = $poll->id;
    }

    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
            Attendance::ATTENDANCE_SHOW_PERMISSION,
            Attendance::ATTENDANCE_EDIT_PERMISSION,
            AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION,
            AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION,
        ];
    }

    public function getRoutesWithPermissions(): array
    {
        return [
            '/events/event/1/attendance' => [Attendance::ATTENDANCE_SHOW_PERMISSION, Attendance::ATTENDANCE_EDIT_PERMISSION],
            '/events/event/1/attendance/edit' => [Attendance::ATTENDANCE_EDIT_PERMISSION],
            "/attendancePolls/$this->pollId/public" => null,
            "/attendancePolls/$this->pollId/index" => null,

            '/attendancePolls' => [AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION, AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION],

            '/attendancePolls/create' => [AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION],
            "/attendancePolls/$this->pollId/edit" => [AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION],
        ];
    }
}
